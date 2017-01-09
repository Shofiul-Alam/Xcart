<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View;

use XLite\Core\Database;

/**
 * Vendor selector
 */
class VendorSelect extends \XLite\View\AView
{
    /**
     * Vendor selector options constants
     */
    const PARAM_FIELD_NAME = 'fieldName';
    const PARAM_SELECTED_VENDOR_IDS = 'selectedVendorIds';

    /**
     * Get vendors list
     *
     * @return array
     */
    public function getVendors()
    {
        $repo = Database::getRepo('XLite\Model\Profile');

        return $repo->findAllVendors();
    }

    /**
     * Return vendor name
     *
     * @param array $vendor Vendor model
     *
     * @return string
     */
    protected function getVendorOptionCaption($vendor)
    {
        return $vendor->getVendorCompanyName();
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/XC/MultiVendor/common/select_vendor.twig';
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_FIELD_NAME          => new \XLite\Model\WidgetParam\TypeString('Field name', ''),
            static::PARAM_SELECTED_VENDOR_IDS => new \XLite\Model\WidgetParam\TypeCollection('Selected vendor ids', array()),
        );
    }

    /**
     * Check if specified vendor is selected
     *
     * @param \XLite\Model\Profile $vendor Vendor
     *
     * @return boolean
     */
    protected function isVendorSelected($vendor)
    {
        return in_array($vendor->getProfileId(), (array)$this->getParam(static::PARAM_SELECTED_VENDOR_IDS));
    }
}
