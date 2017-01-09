<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\Coupons\View;

/**
 * Cart
 *
 * @Decorator\Depend ("CDev\Coupons")
 */
class Cart extends \XLite\View\Cart implements \XLite\Base\IDecorator
{
    /**
     * Get coupons
     *
     * @return array
     */
    protected function getDiscountCoupons()
    {
        if (null === $this->discountCoupons) {
            $cart = $this->getCart();

            foreach ($cart->getUsedCoupons() as $usedCoupon) {
                $this->discountCoupons[$usedCoupon->getCode()] = $usedCoupon;
            }

            foreach ($cart->getChildren() as $child) {
                foreach ($child->getUsedCoupons() as $usedCoupon) {
                    $this->discountCoupons[$usedCoupon->getCode()] = $usedCoupon;
                }
            }

            $this->discountCoupons = array_values($this->discountCoupons);
        }

        return $this->discountCoupons;
    }
}
