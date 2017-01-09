<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ItemsList\Model;

/**
 * U products items list
 */
class VendorProducts extends \XLite\View\ItemsList\Model\Product\AProduct
{
    /**
     * Widget param names
     */
    const PARAM_SUBSTRING           = 'substring';
    const PARAM_CATEGORY_ID         = 'categoryId';
    const PARAM_SEARCH_IN_SUBCATS   = 'searchInSubcats';
    const PARAM_BY_TITLE            = 'by_title';
    const PARAM_BY_DESCR            = 'by_descr';
    const PARAM_BY_SKU              = 'by_sku';
    const PARAM_INVENTORY           = 'inventory';
    const PARAM_ENABLED             = 'enabled';
    const PARAM_PROFILE_ID          = 'profile_id';

    /**
     * Define and set widget attributes; initialize widget
     *
     * @param array $params Widget params OPTIONAL
     *
     * @return void
     */
    public function __construct(array $params = array())
    {
        $this->sortByModes += array(
            static::SORT_BY_MODE_PRICE  => 'Price',
            static::SORT_BY_MODE_NAME   => 'Name',
            static::SORT_BY_MODE_SKU    => 'SKU',
            static::SORT_BY_MODE_AMOUNT => 'Amount',
        );

        parent::__construct($params);
    }

    /**
     * Return list of allowed targets
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        return array_merge(
            parent::getAllowedTargets(),
            array('vendor_products')
        );
    }

    /**
     * Should itemsList be wrapped with form
     *
     * @return boolean
     */
    protected function wrapWithFormByDefault()
    {
        return true;
    }

    /**
     * Get wrapper form target
     *
     * @return array
     */
    protected function getFormTarget()
    {
        return 'vendor_products';
    }

    /**
     * Get list name suffixes
     *
     * @return array
     */
    protected function getListNameSuffixes()
    {
        return array_merge(parent::getListNameSuffixes(), array('search'));
    }

    /**
     * Get search panel widget class
     *
     * @return string
     */
    protected function getSearchPanelClass()
    {
        return 'XLite\Module\XC\MultiVendor\View\SearchPanel\VendorProducts\Main';
    }

    /**
     * Should search params values be saved to session or not
     *
     * @return boolean
     */
    protected function saveSearchConditions()
    {
        return true;
    }

    /**
     * Get search case (aggregated search conditions) processor
     * This should be passed in here by the controller, but i don't see appropriate way to do so
     *
     * @return \XLite\View\ItemsList\ISearchCaseProvider
     */
    public static function getSearchCaseProcessor()
    {
        return new \XLite\View\ItemsList\SearchCaseProcessor(
            static::getSearchParams(),
            static::getSearchValuesStorage()
        );
    }

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        return array(
            'sku' => array(
                static::COLUMN_NAME    => \XLite\Core\Translation::lbl('SKU'),
                static::COLUMN_NO_WRAP => true,
                static::COLUMN_SORT    => static::SORT_BY_MODE_SKU,
                static::COLUMN_ORDERBY => 100,
            ),
            'name' => array(
                static::COLUMN_NAME    => \XLite\Core\Translation::lbl('Name'),
                static::COLUMN_MAIN    => true,
                static::COLUMN_NO_WRAP => true,
                static::COLUMN_SORT    => static::SORT_BY_MODE_NAME,
                static::COLUMN_ORDERBY => 200,
                static::COLUMN_LINK    => 'product',
            ),
            'category' => array(
                static::COLUMN_NAME    => \XLite\Core\Translation::lbl('Category'),
                static::COLUMN_NO_WRAP => true,
                static::COLUMN_ORDERBY => 300,
            ),
            'price' => array(
                static::COLUMN_NAME    => \XLite\Core\Translation::lbl('Price'),
                static::COLUMN_SORT    => static::SORT_BY_MODE_PRICE,
                static::COLUMN_ORDERBY => 400,
            ),
            'qty' => array(
                static::COLUMN_NAME    => \XLite\Core\Translation::lbl('Stock'),
                static::COLUMN_SORT    => static::SORT_BY_MODE_AMOUNT,
                static::COLUMN_ORDERBY => 500,
            ),
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
        $list[] = 'modules/XC/MultiVendor/profile/products.css';

        return $list;
    }

    /**
     * The product column displays the product name
     *
     * @param \XLite\Model\Product $product Product info
     *
     * @return string
     */
    protected function preprocessPrice($price, array $column, \XLite\Model\Product $entity)
    {
        return self::formatPrice($price);
    }

    /**
     * Preprocess category
     *
     * @param integer              $date   Date
     * @param array                $column Column data
     * @param \XLite\Model\Product $entity Product
     *
     * @return string
     */
    protected function preprocessCategory($date, array $column, \XLite\Model\Product $entity)
    {
        return $date
            ? func_htmlspecialchars($date->getName())
            : '';
    }

    /**
     * Define repository name
     *
     * @return string
     */
    protected function defineRepositoryName()
    {
        return 'XLite\Model\Product';
    }

    /**
     * Define widget params
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_PROFILE_ID => new \XLite\Model\WidgetParam\TypeInt(
                'profile ID ', $this->getProfileId(), false
            ),
        );
    }

    /**
     * Get container class
     *
     * @return string
     */

    protected function getContainerClass()
    {
        return parent::getContainerClass() . ' vendor_products';
    }

    /**
     * Check - sticky panel is visible or not
     *
     * @return boolean
     */
    protected function isPanelVisible()
    {
        return false;
    }

    // {{{ Search
    /**
     * Return search parameters.
     *
     * @return array
     */
    public static function getSearchParams()
    {
        return array_merge(
            parent::getSearchParams(),
            array(
                static::PARAM_SUBSTRING    => array(
                    'condition'     => new \XLite\Model\SearchCondition\RepositoryHandler('substring'),
                    'widget'            => array(
                        \XLite\View\SearchPanel\ASearchPanel::CONDITION_CLASS => 'XLite\View\FormField\Input\Text',
                        \XLite\View\FormField\Input\Text::PARAM_PLACEHOLDER => static::t('Search keywords'),
                        \XLite\View\FormField\AFormField::PARAM_FIELD_ONLY => true,
                    ),
                ),
                static::PARAM_CATEGORY_ID    => array(
                    'condition'     => new \XLite\Model\SearchCondition\RepositoryHandler('categoryId'),
                    'widget'            => array(
                        \XLite\View\SearchPanel\ASearchPanel::CONDITION_CLASS => 'XLite\View\FormField\Select\Category',
                        \XLite\View\FormField\Select\Category::PARAM_DISPLAY_ANY_CATEGORY => true,
                        \XLite\View\FormField\AFormField::PARAM_FIELD_ONLY => true,
                    ),
                ),
                static::PARAM_INVENTORY    => array(
                    'condition'     => new \XLite\Model\SearchCondition\RepositoryHandler('inventory'),
                    'widget'            => array(
                        \XLite\View\SearchPanel\ASearchPanel::CONDITION_CLASS => 'XLite\View\FormField\Select\InventoryState',
                        \XLite\View\FormField\AFormField::PARAM_FIELD_ONLY => true,
                    ),
                ),
                'by_conditions'      => array(
                    'widget'            => array(
                        \XLite\View\SearchPanel\SimpleSearchPanel::CONDITION_TYPE    => \XLite\View\SearchPanel\SimpleSearchPanel::CONDITION_TYPE_HIDDEN,
                        \XLite\View\SearchPanel\ASearchPanel::CONDITION_TEMPLATE => 'product/search/parts/condition.by_conditions.twig',
                    ),
                ),
                static::PARAM_BY_TITLE    => array(
                    'condition'     => new \XLite\Model\SearchCondition\RepositoryHandler(\XLite\Model\Repo\Product::P_BY_TITLE),
                ),
                static::PARAM_BY_DESCR    => array(
                    'condition'     => new \XLite\Model\SearchCondition\RepositoryHandler(\XLite\Model\Repo\Product::P_BY_DESCR),
                ),
                static::PARAM_BY_SKU    => array(
                    'condition'     => new \XLite\Model\SearchCondition\RepositoryHandler(\XLite\Model\Repo\Product::P_BY_SKU),
                ),
                static::PARAM_ENABLED           => array(
                    'condition'     => new \XLite\Model\SearchCondition\Expression\TypeEquality('enabled'),
                    'widget'    => array(
                        \XLite\View\SearchPanel\SimpleSearchPanel::CONDITION_TYPE    => \XLite\View\SearchPanel\SimpleSearchPanel::CONDITION_TYPE_HIDDEN,
                        \XLite\View\SearchPanel\ASearchPanel::CONDITION_CLASS => 'XLite\View\FormField\Select\Product\AvailabilityStatus',
                        \XLite\View\FormField\AFormField::PARAM_LABEL => static::t('Availability'),
                    ),
                ),
                static::PARAM_PROFILE_ID    => array(
                    'condition'     => new \XLite\Model\SearchCondition\RepositoryHandler(\XLite\Model\Repo\Product::P_VENDOR_ID),
                ),
            )
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

        // We initialize structure to define order (field and sort direction) in search query.
        $result->{\XLite\Model\Repo\Product::P_ORDER_BY} = $this->getOrderBy();

        // Prepare filter by 'enabled' field
        $enabledFieldName = \XLite\Model\Repo\Product::P_ENABLED;

        if ($result->{$enabledFieldName} && $result->{$enabledFieldName}->getValue()) {
            $booleanValue = 'enabled' === $result->{$enabledFieldName}->getValue()
                ? true
                : false;

            $result->{$enabledFieldName}->setValue($booleanValue);

        } else {
            unset($result->{$enabledFieldName});
        }

        // Correct filter param 'Search in subcategories'
        if (empty($result->{static::PARAM_CATEGORY_ID})) {
            unset($result->{static::PARAM_CATEGORY_ID});
            unset($result->{static::PARAM_SEARCH_IN_SUBCATS});

        } else {
            $result->{static::PARAM_SEARCH_IN_SUBCATS} = true;
        }

        return $result;
    }

    /**
     * getSortByModeDefault
     *
     * @return string
     */
    protected function getSortByModeDefault()
    {
        return static::SORT_BY_MODE_NAME;
    }

    /**
     * Get URL common parameters
     *
     * @return array
     */
    protected function getCommonParams()
    {
        $this->commonParams = parent::getCommonParams();
        $this->commonParams[static::PARAM_PROFILE_ID] = \XLite\Core\Request::getInstance()->profile_id;

        return $this->commonParams;
    }

    // }}}

}
