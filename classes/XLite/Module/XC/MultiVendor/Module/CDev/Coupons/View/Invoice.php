<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\Coupons\View;

/**
 * Invoice
 *
 * @Decorator\Depend ("CDev\Coupons")
 */
abstract class Invoice extends \XLite\View\Invoice implements \XLite\Base\IDecorator
{
    /**
     * Get coupons
     *
     * @return array
     */
    protected function getDiscountCoupons()
    {
        if (null === $this->discountCoupons) {
            $order = $this->getOrder();

            foreach ($order->getUsedCoupons() as $usedCoupon) {
                $this->discountCoupons[$usedCoupon->getCode()] = $usedCoupon;
            }

            foreach ($order->getChildren() as $child) {
                foreach ($child->getUsedCoupons() as $usedCoupon) {
                    $this->discountCoupons[$usedCoupon->getCode()] = $usedCoupon;
                }
            }

            $this->discountCoupons = array_values($this->discountCoupons);
        }

        return $this->discountCoupons;
    }
}
