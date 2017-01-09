<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\Coupons\Model\Repo;

use XLite\Core;

/**
 * Coupon repository
 *
 * @Decorator\Depend ("CDev\Coupons")
 */
class Coupon extends \XLite\Module\CDev\Coupons\Model\Repo\Coupon implements \XLite\Base\IDecorator
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

        $auth = Core\Auth::getInstance();
        if (\XLite::isAdminZone() && $auth->isVendor()) {
            $qb->andWhere('c.vendor = :vendor')
                ->setParameter('vendor', $auth->getProfile());
        }

        return $qb;
    }
}
