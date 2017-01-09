<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View;

use XLite\Core;

/**
 * Vendor info widget for sidebar
 *
 * @ListChild (list="sidebar.single", zone="customer", weight="10")
 * @ListChild (list="sidebar.first", zone="customer", weight="10")
 */
class VendorInfoBlockContent extends \XLite\View\SideBarBox
{
    /**
     * Widget parameter names
     */
    const PARAM_VENDOR_ID = 'vendor_id';

    /**
     * Override: maximum dimensions of a vendor image
     */
    const VENDOR_IMAGE_MAX_WIDTH = 220;
    const VENDOR_IMAGE_MAX_HEIGHT = 350;


    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = array(
            'file'  => 'modules/XC/MultiVendor/product/vendor_info/style.less',
            'media' => 'screen',
            'merge' => 'bootstrap/css/bootstrap.less',
        );
        $list[] = array(
            'file'  => 'modules/XC/MultiVendor/sidebar/vendor_info/style.less',
            'media' => 'screen',
            'merge' => 'bootstrap/css/bootstrap.less',
        );

        return $list;
    }

    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'modules/XC/MultiVendor/sidebar/vendor_info/script.js';

        return $list;
    }

    /**
     * Register the CSS classes for this block
     *
     * @return string
     */
    protected function getBlockClasses()
    {
        return parent::getBlockClasses() . ' block-vendor-info';
    }

    /**
     * Only visible on a vendor page
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible() && $this->getVendor() && $this->getVendor()->isVendor();
    }

    /**
     * Get Vendor ID from request data
     *
     * @return integer
     */
    protected function getVendorId()
    {
        return (int) Core\Request::getInstance()->{static::PARAM_VENDOR_ID};
    }

    /**
     * Get current product vendor
     *
     * @return \XLite\Model\Profile
     */
    protected function getVendor()
    {
        return Core\Database::getRepo('XLite\Model\Profile')->find($this->getVendorId());
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDir()
    {
        return 'modules/XC/MultiVendor/sidebar/vendor_info';
    }

    /**
     * Check if vendor has an image
     *
     * @return boolean
     */
    protected function hasVendorImage()
    {
        return (bool) $this->getVendor()->getVendorImage();
    }

    /**
     * Returns vendor image
     *
     * @return \XLite\Module\XC\MultiVendor\Model\Image\Vendor
     */
    protected function getVendorImage()
    {
        return $this->getVendor()->getVendorImage();
    }

    /**
     * Returns vendor image width
     *
     * @return integer
     */
    protected function getVendorImageWidth()
    {
        return static::VENDOR_IMAGE_MAX_WIDTH;
    }

    /**
     * Returns vendor image width
     *
     * @return integer
     */
    protected function getVendorImageHeight()
    {
        return static::VENDOR_IMAGE_MAX_HEIGHT;
    }

    /**
     * Get vendor product listing page URL
     *
     * @return string
     */
    protected function getVendorPageURL()
    {
        return Core\Converter::buildURL('vendor', '', array('vendor_id' => $this->getVendorId()));
    }

    /**
     * Get vendor name stub
     *
     * @return string
     */
    protected function getVendorCompanyNameStub()
    {
        return \XLite\Module\XC\MultiVendor\Controller\Customer\Vendor::getVendorCompanyNameStub();
    }

    /**
     * Check if current user is a vendor of the page
     *
     * @return boolean
     */
    protected function isVendorLoggedIn()
    {
        $currentVendor = Core\Auth::getInstance()->getVendor();
        $thisVendor = $this->getVendor();

        return $currentVendor && $thisVendor && $currentVendor->getProfileId() == $thisVendor->getProfileId();
    }

    /**
     * Get links for vendor administration tasks
     *
     * @return array
     */
    protected function getVendorBackendLinks()
    {
        return array(
            'home'        => array(
                'title' => static::t('Home'),
                'url'   => Core\URLManager::getShopURL(Core\Converter::buildURL('', '', array(), \XLite::getAdminScript())),
            ),
            'sales'       => array(
                'title' => static::t('Sales'),
                'url'   => Core\URLManager::getShopURL(Core\Converter::buildURL('order_list', 'search', array('filter_id' => 'recent'), \XLite::getAdminScript())),
            ),
            'catalog'     => array(
                'title' => static::t('Catalog'),
                'url'   => Core\URLManager::getShopURL(Core\Converter::buildURL('product_list', '', array(), \XLite::getAdminScript())),
            ),
            'add_product' => array(
                'title' => static::t('Add Product'),
                'url'   => Core\URLManager::getShopURL(Core\Converter::buildURL('product', '', array(), \XLite::getAdminScript())),
            ),
        );
    }
}
