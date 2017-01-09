<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Customer;

use XLite\Core;

/**
 * Vendor controller for customer area
 */
class Vendor extends \XLite\Controller\Customer\ACustomer
{
    /**
     * Controller parameters
     *
     * @var array
     */
    protected $params = array('target', 'vendor_id');

    /**
     * Return the current page title (for the content area)
     *
     * @return string
     */
    public function getTitle()
    {
        $result = parent::getTitle();

        if ($this->isVisible()) {
            $result = $this->getVendor()->getVendorCompanyName()
                ?: static::getVendorCompanyNameStub();
        }

        return $result;
    }

    /**
     * Get vendor name stub
     *
     * @return string
     */
    public static function getVendorCompanyNameStub()
    {
        return static::t("Vendor name");
    }

    /**
     * Check whether the title is to be displayed in the content area
     *
     * @return boolean
     */
    public function isTitleVisible()
    {
        return Core\Request::getInstance()->target !== \XLite::TARGET_404;
    }

    /**
     * Fetch vendor
     *
     * @return \XLite\Model\Profile
     */
    protected function getVendor()
    {
        return Core\Database::getRepo('XLite\Model\Profile')->find(Core\Request::getInstance()->vendor_id);
    }

    /**
     * Check controller visibility
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return $this->getVendor() && $this->getVendor()->isVendor() && $this->getVendor()->isEnabled();
    }

    /**
     * Common method to determine current location
     *
     * @return array
     */
    protected function getLocation()
    {
        return $this->getTitle();
    }
}
