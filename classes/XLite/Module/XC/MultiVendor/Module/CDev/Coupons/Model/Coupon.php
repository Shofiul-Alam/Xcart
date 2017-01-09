<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\Coupons\Model;

use XLite\Core;
use XLite\Model;
use XLite\Module\XC\MultiVendor;

/**
 * Coupon
 *
 * @Decorator\Depend ("CDev\Coupons")
 */
class Coupon extends \XLite\Module\CDev\Coupons\Model\Coupon implements \XLite\Base\IDecorator
{
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
     * Check if current vendor has access to this order
     *
     * @return boolean
     */
    public function isOfCurrentVendor()
    {
        $auth = Core\Auth::getInstance();

        return $auth->isVendor()
            && $this->getVendor()
            && $this->getVendor()->getProfileId() === $auth->getVendorId();
    }

    /**
     * Get amount
     *
     * @param \XLite\Model\Order $order Order
     *
     * @return float
     */
    public function getAmount(Model\Order $order)
    {
        if ($this->isAbsolute()
            && null === $this->getVendor()
            && $order->isChild()
            && !MultiVendor\Main::isWarehouseMode()
        ) {
            $amounts = $this->calculateAmountForChildren($order->getParent());
            $result = $amounts[$order->getOrderId()];

        } else {
            $result = parent::getAmount($order);
        }

        return $result;
    }

    /**
     * Returns distributed amount
     *
     * @param \XLite\Model\Order $parentOrder Parent order
     *
     * @return array
     */
    protected function calculateAmountForChildren($parentOrder)
    {
        $result = array();

        $parentTotal = $this->getOrderTotal($parentOrder);
        $totalAmount = (float) min($parentTotal, $this->getValue());

        foreach ($parentOrder->getChildren() as $child) {
            $result[$child->getOrderId()] = round(($this->getOrderTotal($child) * $totalAmount) / $parentTotal, 4);
        }

        $resultSum = round(array_sum($result), 4);
        if ($resultSum !== $totalAmount) {
            $orderIds = array_keys($result);

            $result[$orderIds[0]] += $totalAmount - $resultSum;
        }

        return $result;
    }

    /**
     * Check coupon compatibility
     *
     * @param \XLite\Model\Order $order Order
     *
     * @throws \XLite\Module\CDev\Coupons\Core\CompatibilityException
     *
     * @return boolean
     */
    public function checkCompatibility(Model\Order $order = null)
    {
        $result = true;

        if ($order && $order->isParent()) {
            if ($this->isSameVendor($order)) {
                $result = parent::checkCompatibility($order);
            } else {
                $found = false;
                foreach ($order->getChildren() as $child) {
                    if ($this->getVendor() && $this->isSameVendor($child)) {
                        $result = parent::checkCompatibility($child);
                        $found = true;
                    }
                }

                if (!$found) {
                    $this->throwCompatibilityException(
                        '',
                        'There is no such a coupon, please check the spelling: X',
                        array('code' => $this->getCode())
                    );
                }
            }
        } else {
            $result = parent::checkCompatibility($order);
        }

        return $result;
    }

    /**
     * Check if coupon is unique within an order
     *
     * @param \XLite\Model\Order $order Order
     *
     * @throws \XLite\Module\CDev\Coupons\Core\CompatibilityException
     *
     * @return boolean
     */
    public function checkUnique(Model\Order $order)
    {
        $result = parent::checkUnique($order);

        if ($result && $order->isParent()) {
            foreach ($order->getChildren() as $child) {
                if (!$this->getVendor() || $this->isSameVendor($child)) {
                    $result = parent::checkUnique($child);
                }
            }
        }

        return $result;
    }

    /**
     * Check coupon vendor
     *
     * @param \XLite\Model\Order $order
     *
     * @return boolean
     */
    public function isSameVendor(Model\Order $order)
    {
        $vendor = $this->getVendor();
        $orderVendor = $order->getVendor();

        return ($vendor === null && $orderVendor === null)
            || ($vendor && $orderVendor && $vendor->getProfileId() === $orderVendor->getProfileId());
    }
}
