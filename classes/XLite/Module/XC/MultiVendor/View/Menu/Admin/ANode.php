<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Menu\Admin;

use XLite\Core\Auth;
use XLite\Model\Role\Permission;

/**
 * Abstract node
 */
class ANode extends \XLite\View\Menu\Admin\ANode implements \XLite\Base\IDecorator
{
    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    protected function checkACL()
    {
        $auth = Auth::getInstance();

        $extraPerm = $this->getParam(self::PARAM_PERMISSION);

        return $this->getParam(self::PARAM_LIST)
        || $this->getParam(self::PARAM_PUBLIC_ACCESS)
        || $extraPerm && $this->isSomePermissionAllowed($extraPerm)
        || !$extraPerm && $auth->isPermissionAllowed(Permission::ROOT_ACCESS);
    }

    /**
     * Check if Auth object allows at least one permission from a list
     *
     * @param array $permissions Permissions to check
     *
     * @return boolean
     */
    protected function isSomePermissionAllowed($permissions)
    {
        if (!is_array($permissions)) {
            $permissions = array($permissions);
        }

        return array_reduce($permissions, function ($result, $perm) {
            return $result || Auth::getInstance()->isPermissionAllowed($perm);
        }, false);
    }
}
