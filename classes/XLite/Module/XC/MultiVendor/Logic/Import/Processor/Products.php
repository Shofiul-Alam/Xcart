<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Logic\Import\Processor;

use XLite\Core;

/**
 * Products import processor
 */
class Products extends \XLite\Logic\Import\Processor\Products implements \XLite\Base\IDecorator
{
    // {{{ Columns

    /**
     * Define columns
     *
     * @return array
     */
    protected function defineColumns()
    {
        $columns = parent::defineColumns();
        $columns['vendor'] = array(
            static::COLUMN_IS_KEY => true,
        );

        return $columns;
    }

    // }}}

    /**
     * Get messages
     *
     * @return array
     */
    public static function getMessages()
    {
        $list = parent::getMessages();
        $list['GLOBAL-VENDOR-FMT'] = 'The "{{value}}" vendor does not exists';

        return $list;
    }

    /**
     * Get error texts
     *
     * @return array
     */
    public static function getErrorTexts()
    {
        $texts = parent::getErrorTexts();
        if (Core\Auth::getInstance()->isVendor()) {
            $texts['GLOBAL-CATEGORY-FMT'] = '';
        }

        return $texts;
    }

    /**
     * Verify 'vendor' value
     *
     * @param mixed $value  Value
     * @param array $column Column info
     *
     * @return void
     */
    protected function verifyVendor($value, array $column)
    {
        if (!Core\Auth::getInstance()->isVendor()
            && !$this->verifyValueAsEmpty($value)
            && !$this->verifyValueAsVendor($value)
        ) {
            $this->addWarning('GLOBAL-VENDOR-FMT', array('column' => $column, 'value' => $value));
        }
    }

    /**
     * Verify value as vendor
     *
     * @param mixed $value Value
     *
     * @return boolean
     */
    protected function verifyValueAsVendor($value)
    {
        $profile = Core\Database::getRepo('XLite\Model\Profile')->findByLogin($value);

        return $profile && $profile->isVendor();
    }

    /**
     * Import 'vendor' value
     *
     * @param \XLite\Model\Product $model  Product
     * @param string               $value  Value
     * @param array                $column Column info
     *
     * @return void
     */
    protected function importVendorColumn(\XLite\Model\Product $model, $value, array $column)
    {
        if ($value
            && !Core\Auth::getInstance()->isVendor()
        ) {
            $profile = Core\Database::getRepo('XLite\Model\Profile')->findByLogin($value);
            if ($profile && $profile->isVendor()) {
                $model->setVendor($profile);
            }
        }
    }

    /**
     * Create model
     *
     * @param array $data Data
     *
     * @return \XLite\Model\AEntity
     */
    protected function createModel(array $data)
    {
        $product = parent::createModel($data);

        $auth = Core\Auth::getInstance();
        if ($auth->isVendor()) {
            $product->setVendor($auth->getVendor());
        }

        return $product;
    }

    /**
     * Add warning
     *
     * @param string  $code      Message code
     * @param array   $arguments Message arguments OPTIONAL
     * @param integer $rowOffset Row offset OPTIONAL
     * @param array   $column    Column info OPTIONAL
     * @param mixed   $value     Value OPTIONAL
     *
     * @return boolean
     */
    protected function addWarning($code, array $arguments = array(), $rowOffset = 0, array $column = array(), $value = null)
    {
        if ('GLOBAL-CATEGORY-FMT' === $code && Core\Auth::getInstance()->isVendor()) {
            parent::addError($code, $arguments, $rowOffset, $column, $value);

        } else {
            parent::addWarning($code, $arguments, $rowOffset, $column, $value);
        }
    }

    /**
     * Add error
     *
     * @param string  $code      Message code
     * @param array   $arguments Message arguments OPTIONAL
     * @param integer $rowOffset Row offset OPTIONAL
     * @param array   $column    Column info OPTIONAL
     * @param mixed   $value     Value OPTIONAL
     *
     * @return boolean
     */
    protected function addError($code, array $arguments = array(), $rowOffset = 0, array $column = array(), $value = null)
    {
        $addError = true;

        if ('VARIANT-PRODUCT-SKU-FMT' === $code) {
            $sku = $arguments['value'];
            $vendor = Core\Auth::getInstance()->getVendor();
            $variantsRepo = Core\Database::getRepo('XLite\Module\XC\ProductVariants\Model\ProductVariant');

            $variants = $variantsRepo->findBySku($sku);

            $variants = array_filter($variants, function ($pv) use ($vendor) {
                return $pv->getProduct()->getVendor() == $vendor;
            });

            if (empty($variants)) {
                $addError = false;
            }
        }

        if ($addError) {
            parent::addError($code, $arguments, $rowOffset, $column, $value);
        }
    }

    /**
     * Assemble model conditions
     *
     * @param array $data Data
     *
     * @return array
     */
    protected function assembleModelConditions(array $data)
    {
        $conditions = parent::assembleModelConditions($data);

        if (!isset($conditions['vendor'])) {
            $conditions['vendor'] = '';
        }

        return $conditions;
    }
}
