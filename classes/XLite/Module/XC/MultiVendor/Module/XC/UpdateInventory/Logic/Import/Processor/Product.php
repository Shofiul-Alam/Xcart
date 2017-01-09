<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\UpdateInventory\Logic\Import\Processor;

/**
 * Update inventory import processor
 *
 * @Decorator\Depend ("XC\UpdateInventory")
 */
class Product extends \XLite\Module\XC\UpdateInventory\Logic\Import\Processor\Inventory implements \XLite\Base\IDecorator
{
    public static function getMessages()
    {
        $result = parent::getMessages();

        if (isset($result['NO-PRODUCT-FOUND'])) {
            $result['NO-PRODUCT-FOUND'] .= ' or vendor mismatch';
        }

        return $result;
    }
}
