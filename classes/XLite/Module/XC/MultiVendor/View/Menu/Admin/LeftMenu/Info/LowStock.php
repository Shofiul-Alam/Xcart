<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Menu\Admin\LeftMenu\Info;

use XLite\Core\Auth;
use XLite\Core\TmpVars;

/**
 * Left side menu widget
 */
class LowStock extends \XLite\View\Menu\Admin\LeftMenu\Info\LowStock implements \XLite\Base\IDecorator
{
    /**
     * Returns last update timestamp
     *
     * @return integer
     */
    protected function getLastUpdateTimestamp()
    {
        $vendor = Auth::getInstance()->getVendor();

        return $vendor ? $this->getLastUpdateTimestampVendor($vendor) : parent::getLastUpdateTimestamp();
    }

    /**
     * Returns last update timestamp for vendor
     *
     * @param \XLite\Model\Profile $vendor Vendor
     *
     * @return integer
     */
    protected function getLastUpdateTimestampVendor($vendor)
    {
        $vendorTimestamps = TmpVars::getInstance()->lowStockUpdateTimestampVendor;

        if (!isset($vendorTimestamps[$vendor->getProfileId()])) {
            $result = LC_START_TIME;
            $vendorTimestamps[$vendor->getProfileId()] = $result;
            TmpVars::getInstance()->lowStockUpdateTimestampVendor = $vendorTimestamps;
        }

        return $vendorTimestamps[$vendor->getProfileId()];
    }
}
