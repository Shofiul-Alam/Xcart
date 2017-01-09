<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Logic\Export\Step;

/**
 * Products
 */
abstract class Products extends \XLite\Logic\Export\Step\Products implements \XLite\Base\IDecorator
{
    /**
     * Define columns
     *
     * @return array
     */
    protected function defineColumns()
    {
        $columns = array();

        foreach (parent::defineColumns() as $field => $options) {
            $columns[$field] = $options;
            if ('sku' === $field) {
                $columns['vendor'] = array();
            }
        }

        return $columns;
    }

    /**
     * Get column value for 'upcIsbn' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getVendorColumnValue(array $dataset, $name, $i)
    {
        $vendor = $dataset['model']->getVendor();

        return $vendor ? $vendor->getLogin() : '';
    }
}
