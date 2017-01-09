<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Core;

use XLite\Core;
use XLite\Module\XC\MultiVendor;

/**
 * Event listener (common)
 */
class EventListener extends \XLite\Core\EventListener implements \XLite\Base\IDecorator
{
    /**
     * Get listeners
     *
     * @return array
     */
    protected function getListeners()
    {
        $listeners = parent::getListeners();

        if (Core\Auth::getInstance()->isVendor()) {
            $vendorExportEventName = MultiVendor\Logic\Vendors::getVendorPrefixedName('export');
            $vendorImportEventName = MultiVendor\Logic\Vendors::getVendorPrefixedName('import');

            $listeners += array(
                $vendorExportEventName => array('XLite\Core\EventListener\Export'),
                $vendorImportEventName => array('XLite\Core\EventListener\Import'),
            );
        }

        return $listeners;
    }
}
