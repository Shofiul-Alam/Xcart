<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ItemsList\Product\Customer;

use XLite\Core;
use XLite\Module\XC\MultiVendor;

/**
 * Vendor products list widget
 *
 * @ListChild (list="center.bottom", zone="customer", weight="200")
 */
class Vendor extends \XLite\View\ItemsList\Product\Customer\ACustomer
{
    /**
     * Widget parameter names
     */
    const PARAM_VENDOR_ID = 'vendor_id';

    /**
     * Widget target
     */
    const WIDGET_TARGET = 'vendor';

    /**
     * Return search parameters.
     *
     * @return array
     */
    public static function getSearchParams()
    {
        return [
            \XLite\Model\Repo\Product::P_VENDOR_ID => self::PARAM_VENDOR_ID,
        ];
    }

    /**
     * Return target to retrieve this widget from AJAX
     *
     * @return string
     */
    protected static function getWidgetTarget()
    {
        return static::WIDGET_TARGET;
    }

    /**
     * Returns CSS classes for the container element
     *
     * @return string
     */
    public function getListCSSClasses()
    {
        return parent::getListCSSClasses() . ' category-products vendor-products';
    }


    /**
     * Return class name for the list pager
     *
     * @return string
     */
    protected function getPagerClass()
    {
        return 'XLite\Module\XC\MultiVendor\View\Pager\Customer\Product\Vendor';
    }

    /**
     * Get requested vendor object
     *
     * @return \XLite\Model\Profile
     */
    protected function getVendor()
    {
        $vendorId = $this->getVendorId();
        return $this->executeCachedRuntime(function () use ($vendorId) {
            return Core\Database::getRepo('XLite\Model\Profile')->find($vendorId);
        }, ['getVendor', $vendorId]);
    }

    /**
     * Get requested vendor ID
     *
     * @return integer
     */
    protected function getVendorId()
    {
        return Core\Request::getInstance()->{static::PARAM_VENDOR_ID};
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
            static::PARAM_VENDOR_ID => new MultiVendor\Model\WidgetParam\ObjectId\Vendor('Vendor ID'),
        );
    }

    /**
     * Get widget parameters
     *
     * @return array
     */
    protected function getWidgetParameters()
    {
        $list = parent::getWidgetParameters();
        $list[static::PARAM_VENDOR_ID] = Core\Request::getInstance()->{static::PARAM_VENDOR_ID};

        return $list;
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

    // {{{ Cache

    /**
     * Get cache parameters
     *
     * @return array
     */
    protected function getCacheParameters()
    {
        $list = parent::getCacheParameters();
        $list[] = $this->getVendorId();

        return $list;
    }

    // }}}
}
