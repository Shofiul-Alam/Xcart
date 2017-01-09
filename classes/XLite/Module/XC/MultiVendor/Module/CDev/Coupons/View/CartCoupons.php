<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\Coupons\View;

/**
 * CartCoupons
 *
 * @Decorator\Depend ("CDev\Coupons")
 */
class CartCoupons extends \XLite\Module\CDev\Coupons\View\CartCoupons implements \XLite\Base\IDecorator
{
    /**
     * Get coupons
     *
     * @return array
     */
    protected function getCoupons()
    {
        if (null === $this->coupons) {
            $cart = $this->getCart();

            $this->coupons = $cart->getUsedCoupons()->toArray();
            foreach ($cart->getChildren() as $child) {
                foreach ($child->getUsedCoupons() as $usedCoupon) {
                    $this->coupons[] = $usedCoupon;
                }
            }
        }

        return $this->coupons;
    }
}
