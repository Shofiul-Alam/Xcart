<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Admin;

use Xlite\Core;
use XLite\Module\XC\MultiVendor\View\ItemsList as MultiVendorItemsList;

/**
 * ProfileTransactionsStats
 */
class ProfileTransactionsStats extends \XLite\Controller\Admin\AAdmin
{
    /**
     * Return the current page title (for the content area)
     *
     * @return string
     */
    public function getTitle()
    {
        return static::t('Vendor statistics');
    }

    /**
     * Define the actions with no secure token
     *
     * @return array
     */
    public static function defineFreeFormIdActions()
    {
        $list = parent::defineFreeFormIdActions();
        $list[] = 'search';

        return $list;
    }

    /**
     * Get search condition parameter by name
     *
     * @param string $paramName Parameter name
     *
     * @return mixed
     */
    public function getCondition($paramName)
    {
        $searchParams = $this->getConditions();

        return isset($searchParams[$paramName])
            ? $searchParams[$paramName]
            : null;
    }

    /**
     * Alias for ProfileTransactions::getSessionCellName()
     *
     * @return string
     */
    protected function getSessionCellName()
    {
        return MultiVendorItemsList\Model\ProfileTransactionsStats::getSessionCellName();
    }

    /**
     * Get search conditions
     *
     * @return array
     */
    protected function getConditions()
    {
        $searchParams = \XLite\Core\Session::getInstance()->{$this->getSessionCellName()};

        return is_array($searchParams) ? $searchParams : array();
    }

    /**
     * Clear search conditions
     *
     * @return void
     */
    protected function doActionClearSearch()
    {
        Core\Session::getInstance()->{$this->getSessionCellName()} = array();

        $this->setReturnURL($this->getURL());
    }

    /**
     * Search labels
     *
     * @return void
     */
    protected function doActionSearch()
    {
        $search = array();
        $searchParams = MultiVendorItemsList\Model\ProfileTransactionsStats::getSearchParams();

        foreach ($searchParams as $modelParam => $requestParam) {
            if (isset(Core\Request::getInstance()->$requestParam)) {
                $search[$requestParam] = Core\Request::getInstance()->$requestParam;
            }
        }

        Core\Session::getInstance()->{$this->getSessionCellName()} = $search;

        $this->setReturnURL($this->getURL());
    }

    /**
     * Get itemsList class
     *
     * @return string
     */
    public function getItemsListClass()
    {
        return parent::getItemsListClass() ?: '\XLite\Module\XC\MultiVendor\View\ItemsList\Model\ProfileTransactionsStats';
    }
}
