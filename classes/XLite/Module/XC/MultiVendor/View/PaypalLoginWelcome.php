<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View;

/**
 * Paypal banner
 *
 * @ListChild (list="dashboard-center", zone="admin", weight="20")
 * @Decorator\Depend ("CDev\Paypal")
 */
class PaypalLoginWelcome extends \XLite\View\Dialog
{
    /**
     * Add widget specific CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'main/style.css';
        $list[] = $this->getDir() . '/style.css';

        return $list;
    }

    /**
     * Return templates directory name
     *
     * @return string
     */
    protected function getDir()
    {
        return 'modules/XC/MultiVendor/modules/CDev/Paypal/welcome';
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible()
            && $this->isVendor()
            && !$this->isVendorVerifiedPaypalLogin();
    }

    /**
     * Check if the current admin user has the root access
     *
     * @return boolean
     */
    protected function isVendor()
    {
        return \XLite\Core\Auth::getInstance()->isVendor();
    }

    /**
     * Check if the current admin user has the root access
     *
     * @return boolean
     */
    protected function isVendorVerifiedPaypalLogin()
    {
        return \XLite\Core\Auth::getInstance()->getProfile()->isVerifiedPaypalLogin();
    }

    /**
     * Get financial tab url
     */
    public function getFinancialTabURL()
    {
        return \XLite\Core\Converter::buildURL('financialInfo');
    }

    /**
     * Get financial tab url
     */
    public function getExternalCreateURL()
    {
        return static::t('https://www.paypal.com/webapps/mpp/home');
    }

    /**
     * Get box class
     *
     * @return string
     */
    protected function getBoxClass()
    {
        return 'admin-welcome multivendor-paypal';
    }
}
