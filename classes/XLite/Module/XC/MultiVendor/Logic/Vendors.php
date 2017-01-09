<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Logic;

use XLite\Core\Auth;

/**
 * Vendors
 */
class Vendors extends \XLite\Base
{
    /**
     * Vendor name prefix
     */
    const VENDOR_VAR_PREFIX = 'vendor-';

    /**
     * Prefix an arbitrary identifier with a vendor namespace
     *
     * @param string $name Name to prefix
     *
     * @return string
     */
    public static function getVendorPrefixedName($name)
    {
        if (Auth::getInstance()->isVendor()) {
            $vendorId = Auth::getInstance()->getVendorId();

            $name = static::VENDOR_VAR_PREFIX . $vendorId . '-' . $name;
        }

        return $name;
    }
}
