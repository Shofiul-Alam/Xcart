<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View;

use XLite\Core\Config;
use XLite\Module\XC\MultiVendor;

/**
 * Product filter widget
 *
 * @Decorator\Depend ("XC\ProductFilter")
 */
class Filter extends \XLite\Module\XC\ProductFilter\View\Filter implements \XLite\Base\IDecorator
{
    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/XC/MultiVendor/filter/style.css';

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
        $list[] = 'modules/XC/MultiVendor/filter/script.js';

        return $list;
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        $result = parent::isVisible();

        if (!$result) {
            $visibleForAView = $this->checkTarget() && $this->checkMode() && $this->checkACL();

            $result = $visibleForAView
                && $this->getCategory()
                && $this->getCategory()->getProductsCount() > 1
                && Config::getInstance()->XC->MultiVendor->enable_vendor_filter;

            if ($result) {
                $filterVendor = new MultiVendor\View\Filter\Vendor();
                $result = $filterVendor->isVisible();
            }
        }

        return $result;
    }
}
