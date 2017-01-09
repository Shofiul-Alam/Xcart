<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Logic\Import;

use XLite\Core;
use XLite\Module\XC\MultiVendor;

/**
 * Importer
 */
class Importer extends \XLite\Logic\Import\Importer implements \XLite\Base\IDecorator
{
    /**
     * Vendor import directory path prefix (to be suffixed with vendor id)
     */
    const IMPORT_DIR_VENDOR_PREFIX = 'import-vendor-';

    /**
     * Get import directory path
     *
     * @return string
     */
    public static function getImportDir()
    {
        $dir = parent::getImportDir();

        if (Core\Auth::getInstance()->isVendor()) {
            $dir = static::getVendorImportDir();
        }

        return $dir;
    }

    /**
     * Get processor list
     *
     * @return array
     */
    public static function getProcessorList()
    {
        $processors = parent::getProcessorList();

        if (Core\Auth::getInstance()->isVendor()) {
            $processors = array('XLite\Logic\Import\Processor\Products');
        }

        return $processors;
    }

    /**
     * Get vendor own import path
     *
     * @return string
     */
    public static function getVendorImportDir()
    {
        return static::IMPORT_DIR_VENDOR_PREFIX . Core\Auth::getInstance()->getVendorId();
    }

    /**
     * Get import event name
     *
     * @return string
     */
    public static function getEventName()
    {
        return MultiVendor\Logic\Vendors::getVendorPrefixedName(parent::getEventName());
    }

    /**
     * Get import cancel flag name
     *
     * @return string
     */
    public static function getImportCancelFlagVarName()
    {
        return MultiVendor\Logic\Vendors::getVendorPrefixedName(parent::getImportCancelFlagVarName());
    }
}
