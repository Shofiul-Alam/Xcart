<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Order\Statistics;

use XLite\Core\Auth;

/**
 * Orders summary mini informer (used on Dashboard page)
 */
class MiniInformer extends \XLite\View\Order\Statistics\MiniInformer implements \XLite\Base\IDecorator
{
    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    protected function checkACL()
    {
        return parent::checkACL() || Auth::getInstance()->isPermissionAllowed('[vendor] manage orders');
    }
}
