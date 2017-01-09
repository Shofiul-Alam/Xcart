<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\Repo;

/**
 * Order repository
 * todo: rename to OrderHistoryEvent
 */
class OrderHistoryEvents extends \XLite\Model\Repo\OrderHistoryEvents implements \XLite\Base\IDecorator
{
    /**
     * Returns query builder for findAllByOrder method
     * Combine history events for parent and children orders
     *
     * @param integer|\XLite\Model\Order $order Order
     *
     * @return \XLite\Model\QueryBuilder\AQueryBuilder
     */
    protected function defineFindAllByOrder($order)
    {
        $qb = parent::defineFindAllByOrder($order);

        $qb->linkLeft('o.order', 'oo')
            ->orWhere('oo.parent = :order')
            ->linkLeft('oo.children')
            ->orWhere('children = :order')
            ->addOrderBy('o.event_id', 'DESC');

        return $qb;
    }
}
