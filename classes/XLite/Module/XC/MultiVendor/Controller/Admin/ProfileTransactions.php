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
 * ProfileTransactions
 */
class ProfileTransactions extends \XLite\Controller\Admin\AAdmin
{
    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        return parent::checkACL() || Core\Auth::getInstance()->isPermissionAllowed('[vendor] manage orders');
    }

    /**
     * Return the current page title (for the content area)
     *
     * @return string
     */
    public function getTitle()
    {
        return static::t('Vendor transactions');
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
        return MultiVendorItemsList\Model\ProfileTransactions::getSessionCellName();
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
        $className = $this->getItemsListClass();
        $searchConditionsRequestNames = $className::getSearchParams();

        foreach ($searchConditionsRequestNames as $name => $condition) {
            $requestName = is_string($condition)
                ? $condition
                : $name;
            \XLite\Core\Request::getInstance()->$requestName = null;
        }

        Core\Session::getInstance()->{$this->getSessionCellName()} = array();

        $this->doActionSearch();

        $this->setReturnURL($this->getURL());
    }

    /**
     * Do action search
     *
     * @return void
     */
    protected function doActionSearch()
    {
        parent::doActionSearchItemsList();

        $this->setReturnURL($this->getURL());
    }

    /**
     * Do action search
     *
     * @return void
     */
    protected function doActionSearchItemsList()
    {
        parent::doActionSearchItemsList();

        $this->setReturnURL($this->getURL());
    }

    /**
     * Update list
     *
     * @return void
     */
    protected function doActionUpdate()
    {
        if (!Core\Auth::getInstance()->isVendor()) {
            $list = new MultiVendorItemsList\Model\ProfileTransactions();
            $list->processQuick();
        }
    }

    /**
     * Get itemsList class
     *
     * @return string
     */
    public function getItemsListClass()
    {
        return parent::getItemsListClass() ?: '\XLite\Module\XC\MultiVendor\View\ItemsList\Model\ProfileTransactions';
    }
}
