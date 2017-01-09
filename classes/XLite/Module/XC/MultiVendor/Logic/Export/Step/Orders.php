<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Logic\Export\Step;

/**
 * Orders
 */
class Orders extends \XLite\Logic\Export\Step\Orders implements \XLite\Base\IDecorator
{
    /**
     * Define columns
     *
     * @return array
     */
    protected function defineColumns()
    {
        $columns = parent::defineColumns();

        $multivendorColumns = [
            'vendor' => [],
            'children' => [
                static::COLUMN_ID => true
            ],
            'parent' => [
                static::COLUMN_ID => true
            ],
        ];
        $columns = array_splice($columns, 0, 1) + $multivendorColumns + $columns;

        return $columns;
    }

    /**
     * Get model datasets
     *
     * @param \XLite\Model\AEntity $model Model
     *
     * @return array
     */
    protected function getModelDatasets(\XLite\Model\AEntity $model)
    {
        $datasets = parent::getModelDatasets($model);

        if ($model->isParent()) {
            foreach ($datasets as $key => &$dataset) {
                if (isset($dataset['item'])) {
                    unset($dataset['item']);
                }

                if ($key > 0 && count($dataset) <= 1) {
                    unset($datasets[$key]);
                }
            }
        }

        return $datasets;
    }

    /**
     * Get column value for 'children' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getChildrenColumnValue(array $dataset, $name, $i)
    {
        $children = [];

        foreach ($dataset['model']->getChildren() as $child) {
            $children[] = $child->getOrderNumber();
        }

        return $children;
    }

    /**
     * Get column value for 'children' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getParentColumnValue(array $dataset, $name, $i)
    {
        if ($parent = $dataset['model']->getParent()) {
            return $parent->getOrderNumber();
        }

        return '';
    }

    /**
     * Get column value for 'children' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getVendorColumnValue(array $dataset, $name, $i)
    {
        if ($vendor = $dataset['model']->getVendor()) {
            return $vendor->getLogin();
        }

        return '';
    }
}