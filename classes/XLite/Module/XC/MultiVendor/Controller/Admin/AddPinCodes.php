<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Admin;

use XLite\Core\Auth;

/**
 * PINCodes selected controller
 *
 * @Decorator\Depend("CDev\PINCodes")
 */
abstract class AddPinCodes
    extends \XLite\Module\CDev\PINCodes\Controller\Admin\AddPinCodes
    implements \XLite\Base\IDecorator
{
    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        return parent::checkACL() || Auth::getInstance()->isPermissionAllowed('[vendor] manage catalog');
    }
}