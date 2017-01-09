<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ItemsList\Product\Customer;

/**
 * Search
 */
class Search extends \XLite\View\ItemsList\Product\Customer\Search implements \XLite\Base\IDecorator
{
    /**
     * Widget param names
     */
    const PARAM_VENDOR_ID = 'vendorId';

    /**
     * Return search parameters.
     *
     * @return array
     */
    public static function getSearchParams()
    {
        return parent::getSearchParams() + array(
            \XLite\Model\Repo\Product::P_VENDOR_ID => self::PARAM_VENDOR_ID,
        );
    }

    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/XC/MultiVendor/product/search/search.css';

        return $list;
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
            self::PARAM_VENDOR_ID => new \XLite\Model\WidgetParam\TypeInt('Vendor ID', 0)
        );
    }
}
