<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\UserPermissions\View\ItemsList\Model;

use XLite\Core;

/**
 * Roles items list
 *
 * @Decorator\Depend ("CDev\UserPermissions")
 */
class Roles extends \XLite\Module\CDev\UserPermissions\View\ItemsList\Model\Roles implements \XLite\Base\IDecorator
{
    /**
     * Run-time cache of default vendor role
     *
     * @var \XLite\Model\Role
     */
    protected $defaultVendorRole;

    /**
     * Preprocess value for 'Role' column
     *
     * @param mixed             $value  Value
     * @param array             $column Column data
     * @param \XLite\Model\Role $role   Entity
     *
     * @return string
     */
    protected function preprocessName($value, array $column, \XLite\Model\Role $role)
    {
        $name = parent::preprocessName($value, $column, $role);

        if ($role->isVendor()) {
            $defaultRole = $this->getDefaultVendorRole();
            if ($defaultRole && $defaultRole->getId() === $role->getId()) {
                $name .= ' ' . static::t('(default vendor role)');
            }
        }

        return $name;
    }

    /**
     * Get default vendor role of false (if no role found)
     *
     * @return \XLite\Model\Role|boolean
     */
    protected function getDefaultVendorRole()
    {
        if (!isset($this->defaultVendorRole)) {
            $this->defaultVendorRole = Core\Database::getRepo('XLite\Model\Role')->getDefaultVendorRole();

            if (!$this->defaultVendorRole) {
                $this->defaultVendorRole = false;
            }
        }

        return $this->defaultVendorRole;
    }
}
