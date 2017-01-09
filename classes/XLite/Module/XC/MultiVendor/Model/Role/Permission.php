<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\Role;

/**
 * Permission
 */
class Permission extends \XLite\Model\Role\Permission implements \XLite\Base\IDecorator
{
    /**
     * Permission code which indicates that it is an exclusive vendor's permission
     */
    const VENDOR_PERM_CODE_PREFIX = '[vendor]';

    /**
     * Check if permission code is vendor's and should be treated separately
     *
     * @param string $code Permission code
     *
     * @return boolean
     */
    public static function isVendorsPermissionCode($code)
    {
        return strpos($code, static::VENDOR_PERM_CODE_PREFIX) === 0;
    }

    /**
     * Use this method to check if the given permission code allows with the permission
     *
     * @param string $code Permission code
     *
     * @return boolean
     */
    public function isAllowed($code)
    {
        return static::isVendorsPermissionCode($code)
            ? $this->getCode() == $code
            : in_array($this->getCode(), array(static::ROOT_ACCESS, $code));
    }

    /**
     * Check if it's a vendors permission
     *
     * @return boolean
     */
    public function isVendorsPermission()
    {
        return static::isVendorsPermissionCode($this->getCode());
    }
}
