<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\Repo;

use XLite\Core;
use XLite\Model\Repo;

/**
 * The "order_item" model repository
 */
class OrderItem extends \XLite\Model\Repo\OrderItem implements \XLite\Base\IDecorator
{
    /**
     * Detach product w/o remove from database
     *
     * @param \XLite\Model\Product $product
     */
    public function detachVendorProduct(\XLite\Model\Product $product)
    {
        $qb = $this->getQueryBuilder()
            ->update($this->_entityName, 'o')
            ->set('o.object', 'NULL')
            ->set('o.originalProduct', ':product')
            ->where('o.object = :product')
            ->setParameter('product', $product);

        $qb->getQuery()->execute();
    }

    /**
     * Prepare top sellers search condition
     *
     * @param \XLite\Core\CommonCell $cnd Conditions
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function prepareTopSellersCondition(\XLite\Core\CommonCell $cnd)
    {
        $queryBuilder = parent::prepareTopSellersCondition($cnd);
        $auth = Core\Auth::getInstance();

        if (isset($cnd->vendor_id)
            || $auth->isVendor()
        ) {
            $vendorId = $auth->isVendor()
                ? $auth->getVendor()->getProfileId()
                : $cnd->vendor_id;

            if (Repo\Profile::ADMIN_VENDOR_FAKE_ID == $cnd->vendor_id) {
                $queryBuilder->join('o.object', 'product')
                    ->andWhere('product.vendor IS NULL');

            } else {
                $queryBuilder->join('o.object', 'product')
                    ->andWhere('product.vendor = :vendor')
                    ->setParameter('vendor', $vendorId);
            }
        }

        return $queryBuilder;
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param integer                    $value        Condition data
     *
     * @return void
     */
    protected function prepareCndOrder(\Doctrine\ORM\QueryBuilder $queryBuilder, $value)
    {
        if ($value) {
            $queryBuilder->linkLeft('o.order', 'oo')
                ->andWhere(
                    $queryBuilder->expr()->orX(
                        'o.order = :order',
                        'oo.parent = :order'
                    )
                )
                ->setParameter('order', $value);

            $auth = Core\Auth::getInstance();
            if ($auth->isVendor()) {
                $queryBuilder->andWhere('o.vendor = :vendor')
                    ->setParameter('vendor', $auth->getVendor());
            }
        }
    }
}
