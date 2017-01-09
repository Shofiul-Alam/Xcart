<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View;

use XLite\Core\Database;
use XLite\Core\Request;

/**
 * Vendor info block on a vendor product listing page
 *
 * @ListChild (list="sidebar.single", zone="customer", weight="150")
 * @ListChild (list="sidebar.first", zone="customer", weight="150")
 */
class VendorsBlock extends \XLite\View\SideBarBox
{
    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = array(
            'file'  => 'modules/XC/MultiVendor/sidebar/vendors/style.less',
            'media' => 'screen',
            'merge' => 'bootstrap/css/bootstrap.less',
        );

        return $list;
    }

    /**
     * Get vendor's page URL
     *
     * @param \XLite\Model\Profile $vendor Vendor model
     *
     * @return string
     */
    protected function getVendorPageUrl($vendor)
    {
        return $this->buildURL('vendor', '', array('vendor_id' => $vendor->getProfileId()));
    }

    /**
     * Get all registered vendors
     *
     * @return array
     */
    protected function getVendors()
    {
        return Database::getRepo('XLite\Model\Profile')->findAllVendors();
    }

    /**
     * Get widget title
     *
     * @return string
     */
    protected function getHead()
    {
        return static::t('Vendors');
    }

    /**
     * Get widget templates directory
     *
     * @return string
     */
    protected function getDir()
    {
        return 'modules/XC/MultiVendor/sidebar/vendors';
    }

    /**
     * Register the CSS classes for this block
     *
     * @return string
     */
    protected function getBlockClasses()
    {
        return parent::getBlockClasses() . ' block-vendors';
    }

    /**
     * Only visible when vendor is logged in
     *
     * @return boolean
     */
    protected function isVisible()
    {
        $vendorPage = Request::getInstance()->target === 'vendor';

        return parent::isVisible()
            && $this->getVendors()
            && !$vendorPage
            && \XLite\Core\Config::getInstance()->XC->MultiVendor->enable_vendor_block;
    }
}
