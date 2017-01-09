<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ItemsList\Model\Order\Admin;

/**
 * Search total block (for order list page)
 */
class SearchTotal extends \XLite\View\ItemsList\Model\Order\Admin\SearchTotal implements \XLite\Base\IDecorator
{
    /**
     * Search total amount
     *
     * @return \Doctrine\ORM\PersistentCollection
     */
    protected function getSearchTotals()
    {
        $cnd = $this->getSearchCondition();
        
        if (\XLite\Core\Auth::getInstance()->isVendor()) {
            $earnings = \XLite\Core\Database::getRepo('XLite\Model\Order')->getEarningsSearchTotal($cnd);

            if (!$earnings) {
                $earnings = array(
                    array(
                        'orders_total' => 0
                    )
                );
            }

            return $earnings;
        } else {
            if ($cnd->{\XLite\Model\Repo\Order::P_VENDOR} && $cnd->{\XLite\Model\Repo\Order::P_VENDOR_ID}) {
                unset($cnd->{\XLite\Model\Repo\Order::P_VENDOR});
            }

            return \XLite\Core\Database::getRepo('XLite\Model\Order')->search($cnd, \XLite\Model\Repo\Order::SEARCH_MODE_TOTALS);
        }
    }
}