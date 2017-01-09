<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Admin;

use XLite\Core\Auth;

/**
 * Orders list controller
 */
abstract class OrderList extends \XLite\Controller\Admin\OrderList implements \XLite\Base\IDecorator
{
    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        return parent::checkACL() || Auth::getInstance()->isPermissionAllowed('[vendor] manage orders');
    }

    /**
     * Clear search conditions for searchTotal
     *
     * @return void
     */
    protected function clearSearchTotalConditions()
    {
        parent::clearSearchTotalConditions();

        $searchTotalSessionCell = \XLite\Module\XC\MultiVendor\View\ItemsList\Model\Order\Admin\EarningsTotal::getSessionCellName();
        \XLite\Core\Session::getInstance()->{$searchTotalSessionCell} = array();
    }

    /**
     * Do common action 'save_search_filter'
     *
     * @return void
     */
    protected function doActionSaveSearchFilter()
    {
        if (Auth::getInstance()->isVendor()) {
            return;
        }

        parent::doActionSaveSearchFilter();
    }

    /**
     * Do common action 'save_search_filter'
     *
     * @return void
     */
    protected function doActionDeleteSearchFilter()
    {
        if (Auth::getInstance()->isVendor()) {
            return;
        }

        parent::doActionDeleteSearchFilter();
    }
}
