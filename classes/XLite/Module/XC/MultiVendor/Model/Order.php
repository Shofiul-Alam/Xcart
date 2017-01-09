<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model;

use Doctrine\Common\Collections\ArrayCollection;

use XLite\Core;
use XLite\Model;
use XLite\Module\XC\MultiVendor;

/**
 * Class represents an order
 */
class Order extends \XLite\Model\Order implements \XLite\Base\IDecorator
{
    const SHIPPING_SURCHARGE_CODE = 'SHIPPING';
    const DISCOUNT_SURCHARGE_CODE = 'DISCOUNT';

    /**
     * List of carts by vendors
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OneToMany (targetEntity="XLite\Model\Order", mappedBy="parent", cascade={"all"}, fetch="EAGER")
     */
    protected $children;

    /**
     * Parent cart for vendor cart
     *
     * @var \XLite\Model\Order
     *
     * @ManyToOne (targetEntity="XLite\Model\Order", inversedBy="children", fetch="EAGER")
     * @JoinColumn (name="parent_id", referencedColumnName="order_id", onDelete="SET NULL")
     */
    protected $parent;

    /**
     * Vendor profile
     *
     * @var \XLite\Model\Profile
     *
     * @ManyToOne (targetEntity="XLite\Model\Profile")
     * @JoinColumn (name="vendor_id", referencedColumnName="profile_id", onDelete="SET NULL")
     */
    protected $vendor;

    /**
     * Commission for shop owner
     *
     * @var \XLite\Module\XC\MultiVendor\Model\Commission
     *
     * @OneToOne (
     *      targetEntity="XLite\Module\XC\MultiVendor\Model\Commission",
     *      inversedBy="order",
     *      cascade={"remove"},
     *      fetch="EAGER"
     *  )
     * @JoinColumn (name="commission_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $commission;

    /**
     * Profile transactions for shop owner
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OneToMany (
     *      targetEntity="XLite\Module\XC\MultiVendor\Model\ProfileTransaction",
     *      mappedBy="order"
     * )
     * @JoinColumn (name="order_id", referencedColumnName="order_id")
     */
    protected $profileTransactions;

    /**
     * Constructor
     *
     * @param array $data Entity properties OPTIONAL
     */
    public function __construct(array $data = array())
    {
        $this->children = new ArrayCollection();
        $this->profileTransactions = new ArrayCollection();

        parent::__construct($data);
    }

    /**
     * Defines the commission rate (DST) of the order's vendor
     *
     * @return float
     */
    public function getRevshareFeeDst()
    {
        return $this->getVendor() ? $this->getVendor()->getRevshareFeeDst() : 0;
    }

    /**
     * Defines the commission rate (Shipping) of the order's vendor
     *
     * @return float
     */
    public function getRevshareFeeShipping()
    {
        return $this->getVendor() ? $this->getVendor()->getRevshareFeeShipping() : 0;
    }

    /**
     * Check if current vendor has access to this order
     *
     * @return boolean
     */
    public function isOfCurrentVendor()
    {
        $auth = Core\Auth::getInstance();

        return $auth->isVendor()
            && (($this->getVendor() && $this->getVendor()->getProfileId() === $auth->getVendorId())
                || ($this->isSingle() && $this->hasItemsByVendor($auth->getProfile()))
            );
    }

    /**
     * Check if child order of current vendor present
     *
     * @return boolean
     */
    public function hasChildOfCurrentVendor()
    {
        $auth = Core\Auth::getInstance();

        return $auth->isVendor()
            && array_reduce($this->getChildren()->toArray(), function ($carry, $item) use ($auth) {
                return $carry ?: ($item->getVendor() && $item->getVendor()->getProfileId() === $auth->getVendorId());
            }, false);
    }

    /**
     * Check if cart is child
     *
     * @return boolean
     */
    public function isChild()
    {
        return null !== $this->getParent();
    }

    /**
     * Check if cart is parent
     *
     * @return boolean
     */
    public function isParent()
    {
        return !$this->isChild();
    }

    /**
     * Check if it is old (before 5.2.5) order
     *
     * @return boolean
     */
    public function isSingle()
    {
        return null === $this->getParent() && 0 === $this->children->count();
    }

    /**
     * Returns vendors list for old (before 5.2.5) order
     *
     * @return ArrayCollection
     */
    public function getSingleVendors()
    {
        return array_reduce($this->items->toArray(), function ($carry, $item) {
            if ($item->getItemId() && !$carry->contains($item->getVendor())) {
                $carry->add($item->getVendor());
            }

            return $carry;
        }, new ArrayCollection());
    }

    /**
     * Returns vendors list
     *
     * @return ArrayCollection
     */
    public function getChildrenVendors()
    {
        return array_reduce($this->getChildren()->toArray(), function ($carry, $item) {
            $carry->add($item->getVendor());

            return $carry;
        }, new ArrayCollection());
    }

    /**
     * Check if order has items by vendor
     *
     * @param \XLite\Model\Profile $vendor Vendor
     *
     * @return boolean
     */
    public function hasItemsByVendor($vendor)
    {
        return array_reduce($this->getItems()->toArray(), function ($carry, $item) use ($vendor) {
            return $carry ?: $item->getVendor() && $item->getVendor()->getProfileId() === $vendor->getProfileId();
        }, false);
    }

    /**
     * Check if order has items by any vendor
     * @todo: rename
     *
     * @return boolean
     */
    public function hasItemsByVendors()
    {
        return array_reduce($this->getItems()->toArray(), function ($carry, $item) {
            return $carry ?: $item->getVendor();
        }, false);
    }

    /**
     * Check if order has any shippable items
     *
     * @return boolean
     */
    public function hasShippableProducts()
    {
        return array_reduce($this->getItems()->toArray(), function ($carry, $item) {
            return $carry ?: $item->isShippable();
        }, false);
    }

    /**
     * Returns child instance by vendor
     *
     * @param \XLite\Model\Profile $profile Vendor profile
     *
     * @return \XLite\Model\Order
     */
    public function getChildByVendor($profile)
    {
        $result = null;

        $vendorId = $profile ? $profile->getProfileId() : null;

        foreach ($this->getChildren() as $child) {
            if (($child->getVendor() === null && $profile === null)
                || ($child->getVendor() && $child->getVendor()->getProfileId() === $vendorId)
            ) {
                $result = $child;
                break;
            }
        }

        return $result;
    }

    /**
     * Set payment status
     *
     * @param mixed $paymentStatus Payment status
     *
     * @return void
     */
    public function setPaymentStatus($paymentStatus = null)
    {
        parent::setPaymentStatus($paymentStatus);

        if ($this->isParent()) {
            foreach ($this->getChildren() as $child) {
                $child->setPaymentStatus($paymentStatus);
            }
        }
    }

    /**
     * Set shipping status
     *
     * @param mixed $shippingStatus Shipping status
     *
     * @return void
     */
    public function setShippingStatus($shippingStatus = null)
    {
        parent::setShippingStatus($shippingStatus);

        if ($this->isParent()) {
            foreach ($this->getChildren() as $child) {
                $child->setShippingStatus($shippingStatus);
            }
        }
    }

    /**
     * Set shipping method name
     *
     * @param string $name Method name
     *
     * @return void
     */
    public function setShippingMethodName($name)
    {
        parent::setShippingMethodName($name);

        if ($this->isParent()) {
            foreach ($this->getChildren() as $child) {
                $child->setShippingMethodName($name);
            }
        }
    }

    /**
     * Set payment method name
     *
     * @param string $name Method name
     *
     * @return void
     */
    public function setPaymentMethodName($name)
    {
        parent::setPaymentMethodName($name);

        if ($this->isParent()) {
            foreach ($this->getChildren() as $child) {
                $child->setPaymentMethodName($name);
            }
        }
    }

    /**
     * Renew shipping method
     *
     * @return void
     */
    public function renewShippingMethod()
    {
        $warehouseMode = MultiVendor\Main::isWarehouseMode();

        if (($warehouseMode && $this->isParent())
            || (!$warehouseMode && $this->isChild())
        ) {
            parent::renewShippingMethod();
        }

        if (!$warehouseMode && $this->isParent()) {
            /** @var \XLite\Model\Order $child */
            foreach ($this->getChildren() as $child) {
                $child->renewShippingMethod();
            }
        }
    }

    /**
     * Returns last shipping method id
     *
     * @return integer|null
     */
    public function getLastShippingId()
    {
        if ($this->isChild()) {
            $result = parent::getLastShippingId();
            $vendor = $this->getVendor();
            $vendorId = null === $vendor ? 0 : $vendor->getProfileId();

            $lastShippingIdByVendor = $this->getProfile()->getLastShippingIdByVendor();

            if (isset($lastShippingIdByVendor[$vendorId])) {
                $result = $lastShippingIdByVendor[$vendorId];
            }
        } else {
            $result = parent::getLastShippingId();
        }

        return $result;
    }

    /**
     * Sets last shipping method id used
     *
     * @param integer $value Method id
     *
     * @return void
     */
    public function setLastShippingId($value)
    {
        if ($this->isChild()) {
            $vendor = $this->getVendor();
            $vendorId = null === $vendor ? 0 : $vendor->getProfileId();

            $profile = $this->getProfile();
            if (null !== $profile) {
                $lastShippingIdByVendor = $profile->getLastShippingIdByVendor();
                $lastShippingIdByVendor[$vendorId] = (int)$value;

                $profile->setLastShippingIdByVendor($lastShippingIdByVendor);
            }

        } else {
            parent::setLastShippingId($value);
        }
    }

    /**
     * Returns order items
     *
     * @return \XLite\Model\OrderItem[]
     */
    public function getItems()
    {
        if ($this->isParent() && 0 < $this->getChildren()->count()) {
            $result = array_reduce($this->getChildren()->toArray(), function ($carry, $item) {
                return array_reduce($item->getItems()->toArray(), function ($carry, $item) {
                    $carry->add($item);

                    return $carry;
                }, $carry);
            }, new ArrayCollection());

        } else {
            $result = parent::getItems();
        }

        return $result;
    }

    /**
     * Returns order items
     *
     * @return \XLite\Model\OrderItem[]
     */
    public function getSelfItems()
    {
        return parent::getItems();
    }

    /**
     * Calculate order
     *
     * @return void
     */
    public function calculate()
    {
        if ($this->isParent()) {
            foreach ($this->getChildren() as $child) {
                $child->calculate();
            }
        } else {
            // check items
            foreach ($this->getItems() as $item) {
                if ($item->getObject()
                    && $item->getObject()->getVendor() !== $this->getVendor()
                ) {
                    $this->getItems()->removeElement($item);
                    \XLite\Core\Database::getEM()->remove($item);
                }
            }
        }

        parent::calculate();

        if (null !== $this->getVendor()) {
            $locker = \XLite\Module\XC\MultiVendor\Core\Lock\CommissionLocker::getInstance();

            $locker->waitForUnlocked($this, 2);
            $locker->lock($this);
            $this->calculateCommission();
            $locker->unlock($this);
        }
    }

    /**
     * Calculate order
     *
     * @return void
     */
    public function recalculate()
    {
        if ($this->isParent()) {
            foreach ($this->getChildren() as $child) {
                $child->recalculate();
            }
        }

        parent::recalculate();
    }

    /**
     * Calculate commission
     *
     * @return void
     */
    protected function calculateCommission()
    {
        if (null === $this->getCommission()) {
            $commission = new MultiVendor\Model\Commission();
            $commission->setOrder($this);
            $this->setCommission($commission);
        }

        $this->getCommission()->recalculate();
    }

    /**
     * Normalize items
     * Remove empty child cart
     *
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     *
     * @return void
     */
    public function normalizeItems()
    {
        parent::normalizeItems();

        if ($this->isParent()) {
            foreach ($this->getChildren() as $child) {
                if (!$child->getItems()->count()) {
                    $this->getChildren()->removeElement($child);
                    Core\Database::getEM()->remove($child);
                }
            }
        }
    }

    /**
     * Get surcharges by type
     *
     * @param string $type Surcharge type
     *
     * @return array
     */
    public function getSurchargesByType($type = null)
    {
        if (!($this instanceof Model\Cart)
            && $this->isParent()
        ) {
            $result = parent::getSurchargesByType();
            foreach ($this->getChildren() as $child) {
                foreach ($child->getSurchargesByType($type) as $surcharge) {
                    $result[] = $surcharge;
                }
            }
        } else {
            $result = parent::getSurchargesByType($type);
        }

        if ($this instanceof Model\Cart
            && !MultiVendor\Main::isWarehouseMode()
            && $this->isParent()
            && !$this->hasShippingRatesForAllVendors()
        ) {
            foreach ($result as $k => $surcharge) {
                if (\XLite\Model\Base\Surcharge::TYPE_SHIPPING === $surcharge->getType()) {
                    unset($result[$k]);
                }
            }
        }

        return $result;
    }

    /**
     * Get exclude surcharges (non-included)
     *
     * @return array
     */
    public function getExcludeSurcharges()
    {
        if (!($this instanceof Model\Cart)
            && $this->isParent()
        ) {
            $result = parent::getExcludeSurcharges();
            foreach ($this->getChildren() as $child) {
                foreach ($child->getExcludeSurcharges() as $surcharge) {
                    $result[] = $surcharge;
                }
            }
        } else {
            $result = parent::getExcludeSurcharges();
        }

        return $result;
    }

    /**
     * Get included surcharges
     *
     * @return array
     */
    public function getIncludeSurcharges()
    {
        if (!($this instanceof Model\Cart)
            && $this->isParent()
        ) {
            $result = parent::getIncludeSurcharges();
            foreach ($this->getChildren() as $child) {
                foreach ($child->getIncludeSurcharges() as $surcharge) {
                    $result[] = $surcharge;
                }
            }
        } else {
            $result = parent::getIncludeSurcharges();
        }

        return $result;
    }

    /**
     * Reset order items surcharge
     *
     * @param \XLite\Model\OrderItem[] $items Order items
     *
     * @return array
     */
    public function resetItemsSurcharges($items)
    {
        $orderId = $this->getOrderId();

        /** @var \XLite\Model\OrderItem $item */
        return parent::resetItemsSurcharges(array_filter($items, function ($item) use ($orderId) {
            return $item->getOrder()->getOrderId() === $orderId;
        }));
    }

    /**
     * Reset surcharge
     *
     * @param \XLite\Model\Order\Surcharge $surcharge Surcharge
     *
     * @return \XLite\Model\Order\Surcharge
     */
    public function resetSurcharge($surcharge)
    {
        return ($surcharge->getOwner() && $surcharge->getOwner()->getOrderId() === $this->getOrderId())
            ? parent::resetSurcharge($surcharge)
            : null;
    }

    /**
     * Get surcharge totals
     *
     * @return array
     */
    public function getSurchargeTotals()
    {
        $result = parent::getSurchargeTotals();

        if ($this->isParent()) {
            $childrenCount = $this->getChildren()->count();
            foreach ($result as $code => $surcharge) {
                if ($code === static::SHIPPING_SURCHARGE_CODE
                    && !MultiVendor\Main::isWarehouseMode()
                    && !$this->hasShippingRatesForAllVendors()
                ) {
                    unset($result[$code]);

                } elseif ($surcharge['count'] === $childrenCount) {
                    $result[$code]['count'] = 1;
                }
            }
        }

        return $result;
    }

    /**
     * Check if has shipping rates for all vendors
     *
     * @return boolean
     */
    protected function hasShippingRatesForAllVendors()
    {
        $result = true;

        $ignoreCalculationMode = \XLite\Model\Shipping::isIgnoreLongCalculations();
        \XLite\Model\Shipping::setIgnoreLongCalculationsMode(true);

        foreach ($this->getChildren() as $child) {
            if (!$this->hasShippingRates($child)) {
                $result = false;

                break;
            }
        }

        \XLite\Model\Shipping::setIgnoreLongCalculationsMode($ignoreCalculationMode);

        return $result;
    }

    /**
     * @param \XLite\Model\Order $order Order
     *
     * @return boolean
     */
    protected function hasShippingRates($order)
    {
        $modifier = $order->getModifier(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, 'SHIPPING');

        return $modifier && (!$modifier->canApply() || $modifier->getRates());
    }

    /**
     * Calculate initial order values
     *
     * @return void
     */
    public function calculateInitialValues()
    {
        if ($this->isParent()) {
            $subtotal = 0;
            $total = 0;

            foreach ($this->getChildren() as $child) {
                $subtotal += $child->getSubtotal();
                $total += $child->getTotal();
            }

            $this->setSubtotal($subtotal);
            $this->setTotal($total);

        } else {
            parent::calculateInitialValues();
        }
    }

    /**
     * Called when an order successfully placed by a client
     *
     * @return void
     */
    public function processSucceed()
    {
        parent::processSucceed();

        if ($this->isParent()) {
            foreach ($this->getChildren() as $child) {
                $child->processSucceed();
            }
        }
    }

    /**
     * Create profile transaction for vendor
     *
     * @param float                 $value          Value of transaction, can be negative
     * @param string                $description    Description of transaction              OPTIONAL
     * @param string                $provider       Provider of transaction                 OPTIONAL
     * @param \XLite\Model\Order    $order          Order of transaction                    OPTIONAL
     *
     * @return void
     */
    protected function createProfileTransaction($value, $description = '', $provider = null, $order = null)
    {
        $transaction = new MultiVendor\Model\ProfileTransaction();
        $transaction->setValue($value);
        $transaction->setDescription($description);

        if ($provider) {
            $transaction->setProvider($provider);
        }

        if ($order) {
            $transaction->setOrder($order);
            $transaction->setProfile($order->getVendor());

        } else {
            $transaction->setOrder($this);
            $transaction->setProfile($this->getVendor());
        }

        Core\Database::getEM()->persist($transaction);
        Core\Database::getEM()->flush($transaction);
    }

    /**
     * A "change status" handler
     *
     * @return void
     */
    protected function processCreateDebit()
    {
        parent::processCreateDebit();

        if (null !== $this->getVendor()) {
            if ($this->getCommission()) {
                $this->createProfileTransaction(
                    - $this->getCommission()->getValue(),
                    'Order paid'
                );
            } else {
                \XLite\Logger::getInstance()->log(
                    sprintf(
                        'Order #%s supposed to have commission, but commission is null in Model\Order#processCreateDebit',
                        $this->getOrderId()
                    ),
                    LOG_DEBUG
                );
            }
        }

        if ($this->isParent()) {
            foreach ($this->getChildren() as $child) {
                $child->processCreateDebit();
            }
        }
    }

    /**
     * A "change status" handler
     *
     * @return void
     */
    protected function processCreateCredit()
    {
        parent::processCreateCredit();

        if (null !== $this->getVendor()) {
            if ($this->getCommission()) {
                $this->createProfileTransaction(
                    $this->getCommission()->getValue(),
                    'Order canceled'
                );
            } else {
                \XLite\Logger::getInstance()->log(
                    sprintf(
                        'Order #%s supposed to have commission, but commission is null in Model\Order#processCreateDebit',
                        $this->getOrderId()
                    ),
                    LOG_DEBUG
                );
            }
        }

        if ($this->isParent()) {
            foreach ($this->getChildren() as $child) {
                $child->processCreateCredit();
            }
        }
    }

    /**
     * A "change status" handler
     *
     * @return void
     */
    protected function processProcess()
    {
        parent::processProcess();

        if ($this->isParent()) {
            foreach ($this->getChildren() as $child) {
                $child->processProcess();
            }
        }
    }

    /**
     * Check order statuses
     *
     * @return boolean
     *
     * @PostPersist
     * @PostUpdate
     */
    public function checkStatuses()
    {
        $changed = false;

        if (($this->isParent()
                && (($this instanceof Model\Order && (bool) $this->getOrderNumber())
                    || ($this instanceof Model\Cart && MultiVendor\Main::isWarehouseMode())
                )
            )
            || ($this->isChild()
                && (($this instanceof Model\Order && (bool) $this->getOrderNumber())
                    || ($this instanceof Model\Cart && !MultiVendor\Main::isWarehouseMode())
                )
            )
        ) {
            $changed = parent::checkStatuses();
        }

        return $changed;
    }

    /**
     * Get payment method
     *
     * @return \XLite\Model\Payment\Method|void
     */
    public function getPaymentMethod()
    {
        if ($this->isChild()
            && ($this instanceof Model\Order && (bool) $this->getOrderNumber()
                || $this instanceof Model\Cart && !MultiVendor\Main::isWarehouseMode()
            )
        ) {
            $result = $this->getParent()->getPaymentMethod();
        } else {
            $result = parent::getPaymentMethod();
        }

        return $result;
    }

    /**
     * Get first open (not payed) payment transaction
     *
     * @return \XLite\Model\Payment\Transaction|void
     */
    public function getFirstOpenPaymentTransaction()
    {
        if ($this->isChild()
            && ($this instanceof Model\Order && (bool) $this->getOrderNumber()
                || $this instanceof Model\Cart && !MultiVendor\Main::isWarehouseMode()
            )
        ) {
            $result = $this->getParent()->getFirstOpenPaymentTransaction();

        } else {
            $result = parent::getFirstOpenPaymentTransaction();
        }

        return $result;
    }

    protected static $inventoryLocking = [];

    /**
     * Order processed: decrease products inventory
     *
     * @return void
     */
    protected function decreaseInventory()
    {
        if ($this->isChild()) {
            if (!isset(static::$inventoryLocking[$this->getOrderId()])) {
                static::$inventoryLocking[$this->getOrderId()] = true;
                parent::decreaseInventory();
            }
        } else {
            foreach ($this->getChildren() as $child) {
                $child->decreaseInventory();
            }
        }
    }

    /**
     * Order declined: increase products inventory
     *
     * @return void
     */
    protected function increaseInventory()
    {
        if ($this->isChild()) {
            if (!isset(static::$inventoryLocking[$this->getOrderId()])) {
                static::$inventoryLocking[$this->getOrderId()] = true;
                parent::increaseInventory();
            }
        } else {
            foreach ($this->getChildren() as $child) {
                $child->increaseInventory();
            }
        }
    }

    /**
     * Returns new child for vendor
     *
     * @param \XLite\Model\Profile $profile Vendor profile
     *
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @return \XLite\Model\Order
     */
    public function createChildForVendor($profile)
    {
        $child = new Model\Cart();
        $child->initializeCart();

        $child->setVendor($profile);
        $child->setParent($this);
        $this->addChild($child);

        if ($child->getVendor()
            && $child->getCommission() === null
        ) {
            $commission = new MultiVendor\Model\Commission();
            $commission->setOrder($child);
            \XLite\Core\Database::getEM()->persist($commission);
            $child->setCommission($commission);
        }

        Core\Database::getEM()->persist($child);
        Core\Database::getEM()->flush($child);

        return $child;
    }

    /**
     * Add new child instance
     *
     * @param \XLite\Model\Order $child Child
     *
     * @returns void
     */
    protected function addChild(\XLite\Model\Order $child)
    {
        $this->addChildren($child);
    }

    /**
     * Returns company configuration
     *
     * @return \XLite\Core\ConfigCell
     */
    protected function getCompanyConfiguration()
    {
        $vendor = $this->getVendor();

        return null !== $vendor
            ? MultiVendor\Main::getVendorConfiguration($vendor, array('Company'))
            : parent::getCompanyConfiguration();
    }

    /**
     * Return native getProfile() result (as for child orders this method always returns parent order profile)
     *
     * @return \XLite\Model\Profile
     */
    public function getNativeProfile()
    {
        return parent::getProfile();
    }

    /**
     * Return native getProfile() result (as for child orders this method always returns parent order profile)
     *
     * @return \XLite\Model\Profile
     */
    public function setNativeProfile($profile)
    {
        return $this->profile = $profile;
    }

    /**
     * Return native getOrigProfile() result (as for child orders this method always returns parent order orig_profile)
     *
     * @return \XLite\Model\Profile
     */
    public function getNativeOrigProfile()
    {
        return parent::getOrigProfile();
    }

    // {{{ Lifecycle callbacks

    /**
     * Prepare order before remove operation
     *
     * @return void
     */
    public function prepareBeforeRemove()
    {
        if ($this->isChild()) {
            $profile = $this->getNativeProfile();
            $origProfile = $this->getNativeOrigProfile();

            if ($profile && $profile->isPersistent() && (!$origProfile || $profile->getProfileId() != $origProfile->getProfileId())) {
                \XLite\Core\Database::getRepo('XLite\Model\Profile')->delete($profile);
            }

        } else {
            parent::prepareBeforeRemove();
        }
    }

    /**
     * Since Doctrine lifecycle callbacks do not allow to modify associations, we've added this method
     *
     * @param string $type Type of current operation
     *
     * @return void
     */
    public function prepareEntityBeforeCommit($type)
    {
        if (static::ACTION_DELETE === $type) {
            if ($this->isChild()) {
                $parent = $this->getParent();
                if ($parent->getChildren()->count() === 1) {
                    $this->getRepository()->delete($parent, false);
                } else {
                    $parent->getChildren()->removeElement($this);
                }
            } else {
                /** @var \Doctrine\Common\Collections\Collection $children */
                $children = $this->getChildren();
                if ($children->count()) {
                    foreach ($children as $child) {
                        $children->removeElement($child);
                        $this->getRepository()->delete($child, false);
                    }
                }
            }
        }

        parent::prepareEntityBeforeCommit($type);
    }

    // }}}

    // {{{ Clone

    /**
     * Clone order
     *
     * @return \XLite\Model\Order
     */
    public function cloneEntity()
    {
        $newChildren = array();

        if ($this->isNeedCloneChildren()) {

            if ($this->isParent()) {
                foreach ($this->getChildren() as $child) {
                    $tmp = $child->cloneEntity();
                    \XLite\Core\Database::getEM()->persist($tmp);
                    $newChildren[] = $tmp;
                }
            }
        }

        $newOrder = parent::cloneEntity();

        $newOrder->setVendor($this->getVendor());

        foreach ($newChildren as $newChild) {
            $newOrder->addChildren($newChild);
            $newChild->setParent($newOrder);
        }

        if ($this->getCommission()) {
            $commission = $this->getCommission()->cloneEntity();
            \XLite\Core\Database::getEM()->persist($commission);
            $commission->setOrder($newOrder);
            $newOrder->setCommission($commission);
        }

        return $newOrder;
    }

    /**
     * Return true if it is need to clone children
     *
     * @return boolean
     */
    protected function isNeedCloneChildren()
    {
        return true;
    }

    /**
     * Clone order items
     *
     * @param \XLite\Model\Order $newOrder New Order
     *
     * @return void
     */
    protected function cloneOrderItems($newOrder)
    {
        if ($this->isChild()) {
            parent::cloneOrderItems($newOrder);
        }
    }

    // }}}

    /**
     * Get last payment transaction ID.
     * This data is displayed on the order page, invoice and packing slip
     *
     * @return string|null
     */
    public function getPaymentTransactionId()
    {

        return $this->isChild() && $this->getParent() && $this->getParent()->getPaymentTransactionId()
            ? $this->getParent()->getPaymentTransactionId()
            : parent::getPaymentTransactionId();
    }

    /**
     * Add children
     *
     * @param \XLite\Model\Order $children
     * @return Order
     */
    public function addChildren(\XLite\Model\Order $children)
    {
        $this->children[] = $children;
        return $this;
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \XLite\Model\Order $parent
     * @return Order
     */
    public function setParent(\XLite\Model\Order $parent = null)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * Get parent
     *
     * @return \XLite\Model\Order
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set vendor
     *
     * @param \XLite\Model\Profile $vendor
     * @return Order
     */
    public function setVendor(\XLite\Model\Profile $vendor = null)
    {
        $this->vendor = $vendor;
        return $this;
    }

    /**
     * Get vendor
     *
     * @return \XLite\Model\Profile
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Set commission
     *
     * @param \XLite\Module\XC\MultiVendor\Model\Commission $commission
     * @return Order
     */
    public function setCommission(\XLite\Module\XC\MultiVendor\Model\Commission $commission = null)
    {
        $this->commission = $commission;
        return $this;
    }

    /**
     * Get commission
     *
     * @return \XLite\Module\XC\MultiVendor\Model\Commission
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * Add profileTransactions
     *
     * @param \XLite\Module\XC\MultiVendor\Model\ProfileTransaction $profileTransactions
     * @return Order
     */
    public function addProfileTransactions(\XLite\Module\XC\MultiVendor\Model\ProfileTransaction $profileTransactions)
    {
        $this->profileTransactions[] = $profileTransactions;
        return $this;
    }

    /**
     * Get profileTransactions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProfileTransactions()
    {
        return $this->profileTransactions;
    }

}
