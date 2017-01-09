<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ItemsList\Model;

use XLite\Module\XC\MultiVendor;

/**
 * Search total block (for order list page)
 *
 * @ListChild (list="pager.admin.model.table.right", weight="100", zone="admin")
 */
class ProfileTransactionSearchTotal extends \XLite\Module\XC\MultiVendor\View\ItemsList\Model\ProfileTransactions
{
    /**
     * @var \Doctrine\ORM\PersistentCollection
     */
    private $searchTotalsCache;

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
        $result[] = 'profile_transactions';

        return $result;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/XC/MultiVendor/profile_transactions/search_panel/search_total.block.twig';
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
        $result = $this->searchTotalsCache;

        if (!$result) {
            // Get search conditions
            $name = MultiVendor\View\ItemsList\Model\ProfileTransactions::getSessionCellName();

            $cnd = new \XLite\Core\CommonCell();
            $data = \XLite\Core\Session::getInstance()->$name;

            foreach (MultiVendor\View\ItemsList\Model\ProfileTransactions::getSearchParams() as $key => $value) {
                if (isset($data[$key])) {
                    $cnd->$key = $data[$key];
                }
            }

            if (\XLite\Core\Auth::getInstance()->isVendor()) {
                $profileId = \XLite\Core\Auth::getInstance()->getProfile()->getProfileId();
                $cnd->{MultiVendor\Model\Repo\ProfileTransaction::P_PROFILE} = $profileId;
            }

            $result = \XLite\Core\Database::getRepo($this->defineRepositoryName())
                        ->getSearchTotal($cnd);
        }

        return $result;
    }

    /**
     * Because Flexy is awesome template engine.
     * BTW, http://twig.sensiolabs.org/doc/templates.html#math :)
     *
     * @return decimal
     */
    protected function getSaldo()
    {
        return $this->getBeforeTotal() + ($this->getDebitTotal() - $this->getCreditTotal());
    }

    /**
     * Return total text
     * 
     * @return string
     */
    protected function getTotalText()
    {
        return \XLite\Core\Auth::getInstance()->isVendor()
            ? 'Earning balance'
            : 'Liability';
    }

    /**
     * Get search before total
     * 
     * @return decimal
     */
    protected function getBeforeTotal()
    {
        $totals = $this->getSearchTotals();
        return isset($totals[0]['before_total']) && $totals[0]['before_total']
            ? -1 * $totals[0]['before_total']
            : null;
    }

    /**
     * Get debit total
     * 
     * @return decimal
     */
    protected function getDebitTotal()
    {
        $totals = $this->getSearchTotals();
        return isset($totals[0]['debit_total'])
            ? $totals[0]['debit_total']
            : 0;
    }

    /**
     * Get credit total
     * 
     * @return decimal
     */
    protected function getCreditTotal()
    {
        $totals = $this->getSearchTotals();
        return isset($totals[0]['credit_total'])
            ? $totals[0]['credit_total']
            : 0;
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
     * @return \XLite\Model\Currency
     */
    protected function getSearchTotalCurrency()
    {
        return \XLite::getInstance()->getCurrency();
    }

    /**
     * isVisible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible()
            || 'profile_transactions' == \XLite\Core\Request::getInstance()->target;
    }
}
