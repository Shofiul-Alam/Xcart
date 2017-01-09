<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View;

/**
 * Category widget
 *
 * @ListChild (list="center", zone="customer")
 */
class VendorDescription extends \XLite\View\Dialog
{
    /**
     * Return list of targets allowed for this widget
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $result = parent::getAllowedTargets();
        $result[] = 'vendor';

        return $result;
    }

    /**
     * Return templates directory name
     *
     * @return string
     */
    protected function getDir()
    {
        return 'modules/XC/MultiVendor/vendor_description';
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible() && $this->getVendor();
    }

    /**
     * Fetch vendor
     *
     * @return object
     */
    protected function getVendor()
    {
        return \XLite\Core\Database::getRepo('XLite\Model\Profile')
            ->find(\XLite\Core\Request::getInstance()->vendor_id);
    }
}
