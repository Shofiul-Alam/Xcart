<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\Egoods\Model\Repo;

/**
 * Order  repository
 *
 * @Decorator\Depend ("CDev\Egoods")
 */
abstract class Order extends \XLite\Model\Repo\Order implements \XLite\Base\IDecorator
{
    /**
     * Define query for findAllOrdersWithEgoods() method
     *
     * @param \XLite\Model\Profile $profile Profile OPTIONAL
     *
     * @return \XLite\Model\QuieryBuilder\AQueryBuilder
     */
    protected function defineFindAllOrdersWithEgoodsQuery(\XLite\Model\Profile $profile = null)
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->linkLeft('o.items', 'item')
            ->linkLeft('item.privateAttachments', 'pa')
            ->orderBy('o.date', 'desc');

        $queryBuilder->linkLeft('o.children')
                ->linkLeft('children.items', 'childrenItem')
                ->linkLeft('childrenItem.privateAttachments', 'cpa');

        if ($profile) {
            $queryBuilder->leftJoin('o.orig_profile', 'op')
                ->andWhere('op.profile_id = :opid')
                ->setParameter('opid', $profile->getProfileId());
        };

        return $queryBuilder;
    }
}

