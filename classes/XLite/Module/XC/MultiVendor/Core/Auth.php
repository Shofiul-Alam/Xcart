<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Core;

use XLite\Model\Role\Permission;

/**
 * Authorization routine
 */
class Auth extends \XLite\Core\Auth implements \XLite\Base\IDecorator
{
    /**
     * Gets the access level for vendor
     *
     * @return integer
     */
    public function getVendorAccessLevel()
    {
        return 10;
    }

    /**
     * Check if current profile is vendor's
     *
     * @return boolean
     */
    public function isVendor()
    {
        $profile = $this->getProfile();

        return $profile ? $profile->isVendor() : false;
    }

    /**
     * Get current logged in vendor profile
     *
     * @return \XLite\Model\Profile
     */
    public function getVendor()
    {
        return $this->isVendor() ? $this->getProfile() : null;
    }

    /**
     * Get current logged in vendor ID
     *
     * @return integer
     */
    public function getVendorId()
    {
        return $this->isVendor() ? $this->getProfile()->getProfileId() : null;
    }

    /**
     * Return true if current user is admin (not a vendor) or vendor which is the same as specified
     *
     * @param \XLite\Model\Profile $vendor Vendor profile
     *
     * @return boolean
     */
    public function checkVendorAccess($vendor)
    {
        return $this->isAdmin()
            && (!$this->isVendor() || ($vendor && (int) $this->getVendorId() === (int) $vendor->getProfileId()));
    }

    /**
     * Check if current user has root access permission
     *
     * @return boolean
     */
    public function hasRootAccess()
    {
        return $this->isPermissionAllowed(Permission::ROOT_ACCESS);
    }
}
