<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormField\Select;

use XLite\Core;
use XLite\Model\Repo;

/**
 * Vendor selector
 *
 * @Decorator\Depend ("XC\ProductFilter")
 */
class VendorFilter extends \XLite\View\FormField\Select\ASelect
{
    /**
     * getOptions
     *
     * @return array
     */
    protected function getOptions()
    {
        $list = parent::getOptions();

        return array('' => static::t('Any vendor')) + $list;
    }

    /**
     * Return default options list
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        $list = array();
        $vendors = array();

        if ($this->getCategory()) {
            $vendors = Core\Database::getRepo('XLite\Model\Product')->getCurrentCategoryVendors();
        }

        foreach ($vendors as $vendor) {
            if ($vendor) {
                $list[$vendor->getProfileId()] = $this->getVendorFilterOptionTitle($vendor);
            } else {
                $list[Repo\Profile::ADMIN_VENDOR_FAKE_ID] = static::t('Main vendor');
            }
        }

        return $list;
    }

    /**
     * Get vendor filter option display name
     *
     * @param \XLite\Model\Profile $vendor Vendor model
     *
     * @return mixed
     */
    protected function getVendorFilterOptionTitle($vendor)
    {
        return $vendor->getVendorCompanyName();
    }
}
