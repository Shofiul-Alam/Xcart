<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Admin;

use XLite\Core\Auth;
use XLite\Module\XC\MultiVendor;

/**
 * Shipping method selection controller
 */
abstract class ShippingMethodSelection
    extends \XLite\Controller\Admin\ShippingMethodSelection
    implements \XLite\Base\IDecorator
{
    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        $warehouseMode = MultiVendor\Main::isWarehouseMode();

        return parent::checkACL()
            || (Auth::getInstance()->isPermissionAllowed('[vendor] manage shipping') && !$warehouseMode);
    }
}
