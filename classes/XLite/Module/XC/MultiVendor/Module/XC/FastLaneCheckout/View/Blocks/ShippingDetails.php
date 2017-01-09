<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\FastLaneCheckout\View\Blocks;

/**
 * Checkout order notes
 *
 * @Decorator\Depend("XC\FastLaneCheckout")
 */
class ShippingDetails extends \XLite\Module\XC\FastLaneCheckout\View\Blocks\ShippingDetails implements \XLite\Base\IDecorator
{
    /**
     * Get JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        if (!\XLite\Module\XC\MultiVendor\Main::isWarehouseMode()) {
            $list[] = 'modules/XC/MultiVendor/blocks/shipping_details/shipping-details.js';
        }

        return $list;
    }

    /**
     * @return string description
     */
    protected function getShippingMethod()
    {
        $cart = $this->getCart();

        return $cart
             ? $cart->getShippingMethodName()
             : '';
    }
}
