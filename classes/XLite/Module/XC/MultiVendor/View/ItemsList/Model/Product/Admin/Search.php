<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ItemsList\Model\Product\Admin;

use XLite\Core;
use XLite\Model;
use XLite\Model\Repo;

/**
 * Search product
 */
class Search extends \XLite\View\ItemsList\Model\Product\Admin\Search implements \XLite\Base\IDecorator
{
    /**
     * Widget param names
     */
    const PARAM_VENDOR_ID = 'vendorId';
    const PARAM_VENDOR    = 'vendor';

    /**
     * Sort by vendor mode
     */
    const SORT_BY_MODE_VENDOR = 'vendor.login';

    /**
     * Return search parameters
     *
     * @return array
     */
    public static function getSearchParams()
    {
        return parent::getSearchParams() + array(
            static::PARAM_VENDOR_ID => array(
                'condition'     => new \XLite\Model\SearchCondition\RepositoryHandler(Repo\Product::P_VENDOR_ID),
            ),
            static::PARAM_VENDOR    => array(
                'condition'     => new \XLite\Model\SearchCondition\RepositoryHandler(Repo\Product::P_VENDOR),
            )
        );
    }

    /**
     * Get a list of CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/XC/MultiVendor/product/search/style.css';

        return $list;
    }

    /**
     * Define and set widget attributes; initialize widget
     *
     * @param array $params Widget params OPTIONAL
     *
     * @return \XLite\Module\XC\MultiVendor\View\ItemsList\Model\Product\Admin\Search
     */
    public function __construct(array $params = array())
    {
        $this->sortByModes += array(
            static::SORT_BY_MODE_VENDOR => 'Vendor',
        );

        parent::__construct($params);
    }

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        $columns = parent::defineColumns();

        if (!Core\Auth::getInstance()->isVendor()) {
            $columns += array(
                'vendor_login' => array(
                    static::COLUMN_NAME    => static::t('Vendor'),
                    static::COLUMN_LINK    => 'profile',
                    static::COLUMN_NO_WRAP => true,
                    static::COLUMN_SORT    => static::SORT_BY_MODE_VENDOR,
                    static::COLUMN_ORDERBY => 600,
                ),
            );
        }

        return $columns;
    }

    /**
     * Build entity page URL
     *
     * @param \XLite\Model\AEntity $product Entity
     * @param array                $column  Column data
     *
     * @return string
     */
    protected function buildEntityURL(Model\AEntity $product, array $column)
    {
        $url = '';

        if ($column[static::COLUMN_LINK] === 'profile') {
            if ($product->getVendor()) {
                $url = $this->buildURL(
                    $column[static::COLUMN_LINK],
                    '',
                    array('profile_id' => $product->getVendor()->getProfileId())
                );
            }

        } else {
            $url = parent::buildEntityURL($product, $column);
        }

        return $url;
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
            static::PARAM_VENDOR_ID => new Model\WidgetParam\TypeInt('Vendor ID', 0),
            static::PARAM_VENDOR    => new Model\WidgetParam\TypeString('Vendor', ''),
        );
    }

    /**
     * Return params list to use for search
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getSearchCondition()
    {
        $result = parent::getSearchCondition();

        if (isset($result->{static::PARAM_VENDOR_ID})
            && is_numeric($result->{static::PARAM_VENDOR_ID})
        ) {
            unset($result->{static::PARAM_VENDOR});

        } else {
            unset($result->{static::PARAM_VENDOR_ID});
        }

        return $result;
    }
}
