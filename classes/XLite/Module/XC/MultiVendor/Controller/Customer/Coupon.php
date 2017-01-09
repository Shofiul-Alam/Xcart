<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Customer;

/**
 * Coupon
 *
 * @Decorator\Depend ("CDev\Coupons")
 */
class Coupon extends \XLite\Module\CDev\Coupons\Controller\Customer\Coupon implements \XLite\Base\IDecorator
{
    /**
     * Get used coupon by id
     *
     * @param \XLite\Model\Order $cart Cart
     * @param integer            $id   Used coupon id
     *
     * @return \XLite\Module\CDev\Coupons\Model\UsedCoupon
     */
    protected function getUsedCoupon($cart, $id)
    {
        $result = parent::getUsedCoupon($cart, $id);

        if (null === $result && $cart->isParent()) {
            foreach ($cart->getChildren() as $child) {
                $result = parent::getUsedCoupon($child, $id);

                if ($result) {
                    break;
                }
            }
        }

        return $result;
    }
}
