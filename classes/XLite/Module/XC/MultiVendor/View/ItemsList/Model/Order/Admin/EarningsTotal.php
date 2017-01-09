<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ItemsList\Model\Order\Admin;

/**
 * Search total block (for order list page)
 *
 * @ListChild (list="pager.admin.model.table.right", weight="200", zone="admin")
 */
class EarningsTotal extends \XLite\View\ItemsList\Model\Order\Admin\Search
{
    /*
     * The number of the cells from the end of table to the "Search total" cell
     */
    const SEARCH_TOTAL_CELL_NUMBER_FROM_END = 3;

    /**
     * Return list of targets allowed for this widget
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $result = parent::getAllowedTargets();
        $result[] = 'order_list';

        return $result;
    }

    /**
     * Re-define session cell name to get search condition from search orders list session cell
     *
     * @return string
     */
    public static function getSessionCellName()
    {
        return str_replace('\\', '', 'XLite\View\ItemsList\Model\Order\Admin\Search');
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/XC/MultiVendor/order/earnings_total.twig';
    }

    /**
     * Return number of the search total cell (for "colspan" option)
     *
     * @return array
     */
    protected function getSearchTotalCellColspan()
    {
        $cellNumber = parent::getColumnsCount();

        if ($cellNumber) {
            $cellNumber = $cellNumber - static::SEARCH_TOTAL_CELL_NUMBER_FROM_END + 1;
        }

        return $cellNumber;
    }

    /**
     * Search total amount
     *
     * @return \Doctrine\ORM\PersistentCollection
     */
    protected function getSearchTotals()
    {
        $cnd = $this->getSearchCondition();
        $earnings = \XLite\Core\Database::getRepo('XLite\Model\Order')->getEarningsSearchTotal($cnd);

        if (!\XLite\Core\Auth::getInstance()->isVendor() && isset($earnings[0]['vendors_total'])) {
            $earnings[0]['earnings_total'] = $earnings[0]['vendors_total'] - $earnings[0]['earnings_total'];
        }

        if (!$earnings) {
            $earnings = array(
                array(
                    'earnings_total' => 0
                )
            );
        }

        return $earnings;
    }

    /**
     * Get count of the search total amounts
     *
     * @return integer
     */
    protected function getSearchTotalsCount()
    {
        return count($this->getSearchTotals());
    }

    /**
     * Get count of the search total amounts
     *
     * @param integer $index Current search total index
     *
     * @return integer
     */
    protected function isNeedSearchTotalsSeparator($index)
    {
        $searchTotalsCount = $this->getSearchTotalsCount();

        return 1 < $searchTotalsCount
            && $index < $searchTotalsCount - 1;
    }

    /**
     * Get currency for the search total
     *
     * @param integer $currencyId Currency id
     *
     * @return \XLite\Model\Currency
     */
    protected function getSearchTotalCurrency($currencyId)
    {
        return \XLite\Core\Database::getRepo('XLite\Model\Currency')
            ->findOneBy(array('currency_id' => $currencyId));
    }

    /**
     * Get total name
     * 
     * @return string
     */
    protected function getTotalName()
    {
        return \XLite\Core\Auth::getInstance()->isVendor()
            ? static::t('Earnings total')
            : static::t('Commissions total');
    }

}
