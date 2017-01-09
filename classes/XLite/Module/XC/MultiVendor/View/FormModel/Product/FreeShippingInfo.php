<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormModel\Product;

/**
 * Class FreeShippingInfo
 * @Decorator\Depend ("XC\FreeShipping")
 */
class FreeShippingInfo extends \XLite\View\FormModel\Product\Info implements \XLite\Base\IDecorator
{
    protected function defineFieldsFreeShipping($schema)
    {
        if (!\XLite\Core\Auth::getInstance()->isVendor() || !\XLite\Module\XC\MultiVendor\Main::isWarehouseMode()) {
            $schema = parent::defineFieldsFreeShipping($schema);
        }

        return $schema;
    }
}
