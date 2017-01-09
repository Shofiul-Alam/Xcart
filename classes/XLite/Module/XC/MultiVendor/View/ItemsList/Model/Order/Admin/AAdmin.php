<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ItemsList\Model\Order\Admin;

use XLite\Core\Auth;

/**
 * Abstract admin order-based list
 */
abstract class AAdmin extends \XLite\View\ItemsList\Model\Order\Admin\AAdmin implements \XLite\Base\IDecorator
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
