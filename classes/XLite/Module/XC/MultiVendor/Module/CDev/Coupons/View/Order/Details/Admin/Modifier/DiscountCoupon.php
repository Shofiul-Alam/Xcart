<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\Coupons\View\Order\Details\Admin\Modifier;

/**
 * Discount coupon modifier widget
 *
 * @Decorator\Depend ("CDev\Coupons")
 */
class DiscountCoupon extends \XLite\Module\CDev\Coupons\View\Order\Details\Admin\Modifier\DiscountCoupon implements \XLite\Base\IDecorator
{
    /**
     * Get used coupons
     *
     * @return array
     */
    protected function getUsedCoupons()
    {
        $isVendor = \XLite\Core\Auth::getInstance()->isVendor();
        $order = $this->getOrder();

        $result = !$isVendor || $order->isOfCurrentVendor()
            ? parent::getUsedCoupons()
            : array();

        if ($order->isParent()) {
            foreach ($order->getChildren() as $child) {
                if (!$isVendor || $child->isOfCurrentVendor()) {
                    foreach ($child->getUsedCoupons() as $coupon) {
                        $result[] = $coupon;
                    }
                }
            }
        }

        return $result;
    }
}
