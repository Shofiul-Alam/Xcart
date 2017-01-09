<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model;

use Doctrine\Common\Collections\ArrayCollection;

use XLite\Module\XC\MultiVendor;

/**
 * Class represents an cart
 */
class Cart extends \XLite\Model\Cart implements \XLite\Base\IDecorator
{
    /**
     * Mark cart as order
     *
     * @return void
     */
    public function markAsOrder()
    {
        parent::markAsOrder();

        if ($this->isParent()) {
            /** @var \XLite\Model\Order $child */
            foreach ($this->getChildren() as $child) {
                $child->markAsOrder();
            }

            // We need that hacky flush for orderNumber counter
            \XLite\Core\Database::getEM()->flush();
        }
    }

    /**
     * Should we flush in order number assign
     * N.B. In 'Separate shops' mode we do not flush on child orders
     *
     * @return boolean
     */
    public function isFlushOnOrderNumberAssign()
    {
        return MultiVendor\Main::isWarehouseMode()
            ? parent::isFlushOnOrderNumberAssign()
            : !$this->isChild();
    }

    /**
     * Check warehouseMode status to determine orders to assign numbers to
     *
     * @return void
     */
    public function assignOrderNumber()
    {
        $warehouseMode = MultiVendor\Main::isWarehouseMode();

        if (($this->isParent() && $warehouseMode)
            || ($this->isChild() && !$warehouseMode)
        ) {
            parent::assignOrderNumber();
        }
    }

    /**
     * Returns profile
     *
     * @return \XLite\Model\Profile
     */
    public function getProfile()
    {
        return $this->isChild()
            ? $this->getParent()->getProfile()
            : parent::getProfile();
    }

    /**
     * Set profile
     *
     * @param \XLite\Model\Profile $profile Profile OPTIONAL
     *
     * @return void
     */
    public function setProfile(\XLite\Model\Profile $profile = null)
    {
        if ($this->isChild()) {
            $this->profile = $profile;

        } else {
            parent::setProfile($profile);
        }
    }

    /**
     * Returns original profile
     *
     * @return \XLite\Model\Profile
     */
    public function getOrigProfile()
    {
        return $this->isChild()
            ? $this->getParent()->getOrigProfile()
            : parent::getOrigProfile();
    }

    /**
     * Get item from order by another item
     *
     * @param \XLite\Model\OrderItem $item Another item
     *
     * @return \XLite\Model\OrderItem|void
     */
    public function getItemByItem(\XLite\Model\OrderItem $item)
    {
        if ($this->isParent()) {
            $child = $this->getChildByVendor($item->getVendor());
            $result = $child ? $child->getItemByItem($item) : null;

        } else {
            $result = parent::getItemByItem($item);
        }

        return $result;
    }

    /**
     * Add item to order
     *
     * @param \XLite\Model\OrderItem $newItem Item to add
     *
     * @return boolean
     */
    public function addItem(\XLite\Model\OrderItem $newItem)
    {
        if ($this->isParent()) {
            /** @var \XLite\Model\Profile $vendor */
            $vendor = $newItem->getVendor();

            $child = $this->getChildByVendor($vendor) ?: $this->createChildForVendor($vendor);
            $result = $child->addItem($newItem);

        } else {
            $result = parent::addItem($newItem);
        }

        return $result;
    }

    /**
     * Returns order surcharges
     *
     * @return \XLite\Model\Order\Surcharge[]
     */
    public function getSurcharges()
    {
        if ($this->isParent()) {
            $result = new ArrayCollection(array_reduce($this->getChildren()->toArray(), function ($carry, $item) {
                return array_merge($carry, $item->getSurcharges()->toArray());
            }, parent::getSurcharges()->toArray()));
        } else {
            $result = parent::getSurcharges();
        }

        return $result;
    }

    /**
     * Set shipping id
     *
     * @param integer $shippingId Shipping id
     *
     * @return void
     */
    public function setShippingId($shippingId)
    {
        parent::setShippingId($shippingId);

        if ($this->isParent()) {
            foreach ($this->getChildren() as $child) {
                $child->setShippingId($shippingId);
            }
        }
    }

    /**
     * Get list of vendors without shipping rates
     *
     * @return array
     */
    public function getVendorsWithoutRates()
    {
        $vendors = array();

        if (!MultiVendor\Main::isWarehouseMode()
            && $this->isParent()
        ) {
            /** @var \Xlite\Model\Cart $child */
            foreach ($this->getChildren() as $child) {
                if (!$child) {
                    continue;
                }
                $modifier = $child->getModifier(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, 'SHIPPING');

                if ($modifier && $modifier->canApply() && !$modifier->isRatesExists() && $child->getVendor()) {
                    $vendors[] = $child->getVendor();
                }
            }
        }

        return $vendors;
    }

    /**
     * Get list of vendors with shipping rates
     *
     * @return boolean
     */
    public function hasAdminProducts()
    {
        $result = false;

        if (!MultiVendor\Main::isWarehouseMode()
            && $this->isParent()
        ) {
            /** @var \Xlite\Model\Cart $child */
            foreach ($this->getChildren() as $child) {
                if (null === $child->getVendor()) {
                    $result = true;
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * Get list of vendors with shipping rates
     *
     * @return array
     */
    public function getVendorsWithRates()
    {
        $vendors = array();

        if (!MultiVendor\Main::isWarehouseMode()
            && $this->isParent()
        ) {
            /** @var \Xlite\Model\Cart $child */
            foreach ($this->getChildren() as $child) {
                $modifier = $child->getModifier(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, 'SHIPPING');

                if ($modifier->canApply() && $modifier->isRatesExists() && $child->getVendor()) {
                    $vendors[] = $child->getVendor();
                }
            }
        }

        return $vendors;
    }

    /**
     * Set notes
     *
     * @param text $notes
     * @return Order
     */
    public function setNotes($notes)
    {
        if ($this->isParent() && !MultiVendor\Main::isWarehouseMode()) {
            foreach ($this->getChildren() as $child) {
                $child->setNotes($notes);
            }

        } else {
            parent::setNotes($notes);
        }

        return $this;
    }

    /**
     * Clear cart (remove cart items)
     *
     * @return void
     */
    public function clear()
    {
        if ($this->isParent()) {
            foreach ($this->getChildren() as $child) {
                $child->clear();
            }
        }

        parent::clear();
    }
}
