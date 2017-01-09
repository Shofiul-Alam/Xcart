<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\DTO\Product;


/**
 * Class FreeShippingInfo
 * @Decorator\Depend ("XC\FreeShipping")
 */
class FreeShippingInfo extends \XLite\Model\DTO\Product\Info implements \XLite\Base\IDecorator
{
    protected function initFreeShipping($object)
    {
        if (!\XLite\Core\Auth::getInstance()->isVendor() || !\XLite\Module\XC\MultiVendor\Main::isWarehouseMode()) {
            parent::initFreeShipping($object);
        }
    }

    protected function populateToFreeShipping($object)
    {
        if (!\XLite\Core\Auth::getInstance()->isVendor() || !\XLite\Module\XC\MultiVendor\Main::isWarehouseMode()) {
            parent::populateToFreeShipping($object);
        }
    }
}
