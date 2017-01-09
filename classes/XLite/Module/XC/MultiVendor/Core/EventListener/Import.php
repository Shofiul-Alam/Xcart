<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Core\EventListener;

use XLite\Module\XC\MultiVendor;

/**
 * Import
 */
class Import extends \XLite\Core\EventListener\Import implements \XLite\Base\IDecorator
{
    /**
     * Get import event name
     *
     * @return string
     */
    protected function getEventName()
    {
        return MultiVendor\Logic\Vendors::getVendorPrefixedName(parent::getEventName());
    }
}
