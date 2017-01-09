<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\Coupons\Model;

use XLite\Module\CDev\Coupons;
use XLite\Module\XC\MultiVendor;

/**
 * Class represents an order
 *
 * @Decorator\Depend ("CDev\Coupons")
 */
class Order extends \XLite\Model\Order implements \XLite\Base\IDecorator
{
    /**
     * Common method to update cart/order
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @return void
     */
    public function updateOrder()
    {
        if ($this->isParent() && !MultiVendor\Main::isWarehouseMode()) {
            foreach ($this->getGeneralCoupons() as $coupon) {
                foreach ($this->getChildren() as $child) {
                    if (!$child->containsCoupon($coupon)) {
                        $child->addCoupon($coupon);
                    }
                }
            }

            \XLite\Core\Database::getEM()->flush();
        }

        parent::updateOrder();
    }

    /**
     * Add coupon
     *
     * @param \XLite\Module\CDev\Coupons\Model\Coupon $coupon Coupon
     *
     * @return void
     */
    public function addCoupon(Coupons\Model\Coupon $coupon)
    {
        if ($this->isParent()) {
            /** @var \Xlite\Model\Profile $couponVendor */
            $couponVendor = $coupon->getVendor();
            if (null === $couponVendor && MultiVendor\Main::isWarehouseMode()) {
                parent::addCoupon($coupon);
            } else {
                foreach ($this->getChildren() as $child) {
                    if (null === $couponVendor || $child->isSameVendor($coupon)) {
                        $child->addCoupon($coupon);
                    }
                }
            }
        } else {
            parent::addCoupon($coupon);
        }
    }

    /**
     * Remove coupon
     *
     * @param \XLite\Module\CDev\Coupons\Model\UsedCoupon $usedCoupon Used coupon
     *
     * @return void
     */
    public function removeUsedCoupon(Coupons\Model\UsedCoupon $usedCoupon)
    {
        $couponId = $usedCoupon->getCoupon()->getId();

        if ($this->isParent()) {
            foreach ($this->getChildren() as $child) {
                foreach ($child->getUsedCoupons() as $usedCoupon) {
                    if ($usedCoupon->getCoupon()->getId() === $couponId) {
                        $child->removeUsedCoupon($usedCoupon);
                    }
                }
            }
        }

        foreach ($this->getUsedCoupons() as $usedCoupon) {
            if ($usedCoupon->getCoupon()->getId() === $couponId) {
                parent::removeUsedCoupon($usedCoupon);
            }
        }
    }

    /**
     * Check coupon vendor
     *
     * @param \XLite\Module\CDev\Coupons\Model\Coupon $coupon Coupon
     *
     * @return boolean
     */
    protected function isSameVendor(Coupons\Model\Coupon $coupon)
    {
        return $coupon->isSameVendor($this);
    }

    /**
     * Returns general coupons list
     *
     * @return \XLite\Module\CDev\Coupons\Model\Coupon[]
     */
    protected function getGeneralCoupons()
    {
        $result = array();

        if ($this->Parent()) {
            foreach ($this->getChildren() as $child) {
                foreach ($child->getGeneralCoupons() as $coupon) {
                    $result[$coupon->getId()] = $coupon;
                }
            }
        } else {
            foreach ($this->getUsedCoupons() as $usedCoupon) {
                $coupon = $usedCoupon->getCoupon();
                if (null === $coupon->getVendor()) {
                    $result[$coupon->getId()] = $coupon;
                }
            }
        }

        return $result;
    }
}
