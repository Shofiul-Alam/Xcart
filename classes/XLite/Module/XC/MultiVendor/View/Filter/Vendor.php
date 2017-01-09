<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Filter;

use XLite\Core;
use XLite\Model\Repo;

/**
 * Vendor filter widget
 *
 * @Decorator\Depend ("XC\ProductFilter")
 *
 * @ListChild (list="sidebar.filter", zone="customer", weight="500")
 */
class Vendor extends \XLite\Module\XC\ProductFilter\View\Filter\AFilter
{
    /**
     * Get widget templates directory
     *
     * @return string
     */
    protected function getDir()
    {
        return 'modules/XC/MultiVendor/filter/vendor';
    }

    /**
     * Return default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return $this->getDir() . '/body.twig';
    }

    /**
     * Check widget visibility
     *
     * @return boolean
     */
    protected function isVisible()
    {
        $visible = parent::isVisible() && Core\Config::getInstance()->XC->MultiVendor->enable_vendor_filter;

        if ($visible && $this->getCategory()) {
            $vendors = Core\Database::getRepo('XLite\Model\Product')->getCurrentCategoryVendors();

            $visible = count($vendors) > 1;
        }

        return $visible;
    }

    /**
     * Get value
     *
     * @return string
     */
    protected function getValue()
    {
        $filterValues = $this->getFilterValues();

        return isset($filterValues[$this->getFilterType()]) ? $filterValues[$this->getFilterType()] : '';
    }

    /**
     * Get filter type
     *
     * @return string
     */
    protected function getFilterType()
    {
        return Repo\Product::P_VENDOR_ID;
    }
}
