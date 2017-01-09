<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View;

use XLite\Core\Converter;

/**
 * Vendor info widget for a product
 */
class ProductVendorInfo extends \XLite\View\AView
{
    /**
     * Maximum dimensions of a vendor image
     */
    const VENDOR_IMAGE_MAX_WIDTH = 100;
    const VENDOR_IMAGE_MAX_HEIGHT = 100;

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

        return $list;
    }

    /**
     * Get current product vendor
     *
     * @return mixed
     */
    protected function getVendor()
    {
        return $this->getProduct()->getVendor();
    }

    /**
     * Check if current product has a vendor
     *
     * @return boolean
     */
    protected function hasVendor()
    {
        return (bool)$this->getVendor();
    }

    /**
     * Check if vendor has an image
     *
     * @return boolean
     */
    protected function hasVendorImage()
    {
        return (bool)$this->getVendor()->getVendorImage();
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
        return Converter::buildURL('vendor', '', array('vendor_id' => $this->getVendorId()));
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
     * Get vendor profile ID
     *
     * @return string
     */
    protected function getVendorId()
    {
        return $this->getVendor()->getProfileId();
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/XC/MultiVendor/product/vendor_info.twig';
    }
}
