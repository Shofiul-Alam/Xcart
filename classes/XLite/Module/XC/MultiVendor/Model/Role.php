<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model;

/**
 * Role
 */
class Role extends \XLite\Model\Role implements \XLite\Base\IDecorator
{
    /**
     * Check if current role is vendor's
     *
     * @return boolean
     */
    public function isVendor()
    {
        return array_reduce($this->getPermissions()->toArray(), function ($result, $perm) {
            return $result || $perm->isVendorsPermission();
        }, false);
    }
}
