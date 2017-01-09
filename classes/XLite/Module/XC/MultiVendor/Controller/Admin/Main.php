<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Admin;

use XLite\Core\Auth;
use XLite\Core\TmpVars;

/**
 * Import controller
 */
abstract class Main extends \XLite\Controller\Admin\Main implements \XLite\Base\IDecorator
{
    /**
     * Update menu read timestamp
     *
     * @param string $type Menu type
     */
    protected function updateMenuReadTimestamp($type)
    {
        $vendor = Auth::getInstance()->getVendor();

        if ($vendor) {
            $vendorTimestamps = TmpVars::getInstance()->infoMenuReadTimestampVendor;
            $vendorTimestamps[$vendor->getProfileId()] = LC_START_TIME;
            TmpVars::getInstance()->infoMenuReadTimestampVendor = $vendorTimestamps;

        } else {
            parent::updateMenuReadTimestamp($type);
        }
    }
}
