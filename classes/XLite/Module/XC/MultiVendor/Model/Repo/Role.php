<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\Repo;

/**
 * Role
 */
class Role extends \XLite\Model\Repo\Role implements \XLite\Base\IDecorator
{
    /**
     * Get default vendor role for new users
     *
     * @return \XLite\Model\Role
     */
    public function getDefaultVendorRole()
    {
        $role = null;

        $defaultRoleId = \XLite\Core\Config::getInstance()->XC->MultiVendor->default_role;

        if ($defaultRoleId) {

            $role = $this->find($defaultRoleId);

            if (!($role->getEnabled() && $role->isVendor())) {
                $role = null;
            }
        }

        return $role ?: $this->findFirstVendorRole();
    }

    // {{{ findByPermissionCodePrefix

    /**
     * Find first vendor role
     *
     * @return \XLite\Model\Role
     */
    public function findFirstVendorRole()
    {
        $result = null;

        $roles = $this->findByPermissionCodePrefix(\XLite\Model\Role\Permission::VENDOR_PERM_CODE_PREFIX);

        if ($roles) {
            $result = reset($roles);
        }

        return $result;
    }

    /**
     * Find all roles by permission code prefix
     *
     * @param string $prefix Permission code prefix
     *
     * @return array
     */
    public function findByPermissionCodePrefix($prefix)
    {
        return $this->defineFindByPermissionCodePrefixQuery($prefix)->getResult();
    }

    /**
     * Define query for findByPermissionCodePrefix() method
     *
     * @param string $prefix Permission code prefix
     *
     * @return \XLite\Model\QueryBuilder\AQueryBuilder
     */
    protected function defineFindByPermissionCodePrefixQuery($prefix)
    {
        return $this->createQueryBuilder('r')
            ->linkInner('r.permissions')
            ->andWhere('permissions.code LIKE :prefix')
            ->setParameter('prefix', sprintf('%s%%', $prefix));
    }

    // }}}
}
