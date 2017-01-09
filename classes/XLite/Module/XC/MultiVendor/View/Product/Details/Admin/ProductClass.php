<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Product\Details\Admin;

/**
 * Product class
 */
class ProductClass extends \XLite\View\Product\Details\Admin\ProductClass implements \XLite\Base\IDecorator
{
    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = '/modules/XC/MultiVendor/product/product_class/style.css';

        return $list;
    }
}
