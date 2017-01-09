<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\NotFinishedOrders\Model\Repo;

use XLite\Core\Auth;
use XLite\Module\XC\MultiVendor;

/**
 * Order repository
 *
 * @Decorator\Depend ("XC\NotFinishedOrders")
 */
abstract class Order extends \XLite\Model\Repo\Order implements \XLite\Base\IDecorator
{
    /**
     * Create a new QueryBuilder instance that is pre-populated for this entity name
     *
     * @param string  $alias      Table alias OPTIONAL
     * @param string  $indexBy    The index for the from. OPTIONAL
     * @param boolean $placedOnly Consider only "placed" orders OPTIONAL
     *
     * @return \XLite\Model\QueryBuilder\AQueryBuilder
     */
    public function createQueryBuilder($alias = null, $indexBy = null, $placedOnly = true)
    {
        $qb = parent::createQueryBuilder($alias, $indexBy, $placedOnly);

        if (\XLite::isAdminZone() && Auth::getInstance()->isVendor()) {
            // Do not display not-finished orders to vendor
            $qb->innerJoin('o.shippingStatus', 'oss')
                ->andWhere('oss.code != :shippingStatusNFO')
                ->setParameter('shippingStatusNFO', \XLite\Model\Order\Status\Shipping::STATUS_NOT_FINISHED);

        } else {

        }

        return $qb;
    }

    /**
     * Add not finished condition to query builder
     *
     * @param \Doctrine\ORM\QueryBuilder  $qb      Query Builder
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function defineNotFinishedCndSubquery($qb)
    {
        $result = parent::defineNotFinishedCndSubquery($qb);

        if (Auth::getInstance()->isVendor()) {
            $result->add('o.parent IS NOT NULL');
            $result->add('o.vendor = :currentVendor');
            $qb->setParameter('currentVendor', Auth::getInstance()->getProfile());

        } else {
            $result->add('o.parent IS NULL');
        }

        return $result;
    }
}
