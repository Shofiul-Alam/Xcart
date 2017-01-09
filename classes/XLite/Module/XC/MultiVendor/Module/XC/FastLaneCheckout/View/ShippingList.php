<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\FastLaneCheckout\View;

use XLite\Module\XC\MultiVendor;

/**
 * Shipping list
 *
 * @Decorator\Depend("XC\FastLaneCheckout")
 */
abstract class ShippingList extends \XLite\View\ShippingList implements \XLite\Base\IDecorator
{
    /**
     * Return shipping list widget class name. Should be a child of XLite\View\ShippingList class
     *
     * @return string
     */
    protected function getShippingListWidgetClass()
    {
        return \XLite\Module\XC\FastLaneCheckout\Main::isFastlaneEnabled()
             ? 'XLite\\Module\\XC\\FastLaneCheckout\\View\\Blocks\\ShippingMethods\\Selector'
             : parent::getShippingListWidgetClass();
    }
}
