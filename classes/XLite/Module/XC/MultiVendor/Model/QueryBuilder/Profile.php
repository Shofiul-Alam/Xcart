<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\QueryBuilder;

use Xlite\Core;
use XLite\Model;

/**
 * Profile query builder
 */
class Profile extends \XLite\Model\QueryBuilder\Profile implements \XLite\Base\IDecorator
{
    // {{{ Vendor

    /**
     * Bind only vendor profiles
     *
     * @return \XLite\Model\QueryBuilder\AQueryBuilder
     */
    public function bindVendor()
    {
        $vendorRoles = Core\Database::getRepo('XLite\Model\Role')
            ->findByPermissionCodePrefix(Model\Role\Permission::VENDOR_PERM_CODE_PREFIX);

        return $this->bindRoles($vendorRoles);
    }

    // }}}
}
