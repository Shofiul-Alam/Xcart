<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormField;

use XLite\Core;

/**
 * Vendor profile link
 */
class VendorLink extends \XLite\View\FormField\AFormField
{
    /**
     * Vendor link field type
     */
    const FIELD_TYPE_VENDOR_LINK = 'vendor_link';

    /**
     * getValue
     *
     * @return string
     */
    public function getValue()
    {
        return parent::getValue();
    }

    /**
     * Return field type
     *
     * @return string
     */
    public function getFieldType()
    {
        return static::FIELD_TYPE_VENDOR_LINK;
    }

    /**
     * Return name of the folder with templates
     *
     * @return string
     */
    protected function getDir()
    {
        return 'modules/XC/MultiVendor/form_field';
    }

    /**
     * Return field template
     *
     * @return string
     */
    protected function getFieldTemplate()
    {
        return 'vendor_link.twig';
    }

    /**
     * Get vendor profile model
     *
     * @return \XLite\Model\Profile
     */
    protected function getVendor()
    {
        return $this->getValue();
    }

    /**
     * Get vendor profile login
     *
     * @return string
     */
    protected function getVendorLinkTitle()
    {
        $vendor = $this->getValue();
        $title = '';

        if ($vendor) {
            $title = $vendor->getVendorCompanyName() . ' (' . $vendor->getLogin() . ')';
        }

        return $title;
    }

    /**
     * Get vendor profile url
     *
     * @return string
     */
    protected function getVendorProfileUrl()
    {
        return $this->buildURL(
            'profile',
            '',
            array('profile_id' => $this->getValue()->getProfileId())
        );
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible() && !Core\Auth::getInstance()->isVendor();
    }
}
