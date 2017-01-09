<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\VolumeDiscounts\Model\Repo;

use XLite\Core;
use XLite\Model;
use XLite\Model\Repo;

/**
 * Volume discount
 *
 * @Decorator\Depend ("CDev\VolumeDiscounts")
 */
class VolumeDiscount extends \XLite\Module\CDev\VolumeDiscounts\Model\Repo\VolumeDiscount implements \XLite\Base\IDecorator
{
    const P_VENDOR_ID = 'vendorId';

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
            $qb->andWhere('v.vendor = :vendor')
                ->setParameter('vendor', $auth->getProfile());
        }

        return $qb;
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param array                      $value        Condition data
     * @param boolean                    $countOnly    "Count only" flag. Do not need to add "order by" clauses if only count is needed.
     *
     * @return void
     */
    protected function prepareCndVendorId(\Doctrine\ORM\QueryBuilder $queryBuilder, $value, $countOnly)
    {
        if (0 < $value) {
            $queryBuilder->andWhere('v.vendor = :vendorId')
                ->setParameter('vendorId', $value);

        } elseif (Repo\Profile::ADMIN_VENDOR_FAKE_ID == $value) {
            $queryBuilder->andWhere('v.vendor IS NULL');
        }
    }

    /**
     * Define query for 'findOneSimilarDiscount' method
     *
     * @param \XLite\Module\CDev\VolumeDiscounts\Model\VolumeDiscount $model Discount
     *
     * @return \XLite\Model\QueryBuilder\AQueryBuilder
     */
    protected function defineFindOneSimilarDiscountQuery(\XLite\Module\CDev\VolumeDiscounts\Model\VolumeDiscount $model)
    {
        $qb = parent::defineFindOneSimilarDiscountQuery($model);

        if ($model->getVendor()) {
            $qb->andWhere('v.vendor = :vendor')
                ->setParameter('vendor', $model->getVendor());

        } else {
            $qb->andWhere('v.vendor IS NULL');
        }

        return $qb;
    }

    /**
     * getFirsDiscountCondition
     *
     * @param \XLite\Core\CommonCell $cnd Condition
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getFirstDiscountCondition($cnd)
    {
        $result = parent::getFirstDiscountCondition($cnd);
        $result->{self::P_VENDOR_ID} = $cnd->{self::P_VENDOR_ID} ?: null;

        return $result;
    }

    /**
     * getNextDiscountCondition
     *
     * @param \XLite\Core\CommonCell $cnd Condition
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getNextDiscountCondition($cnd)
    {
        $result = parent::getNextDiscountCondition($cnd);
        $result->{self::P_VENDOR_ID} = null;

        return $result;
    }

    /**
     * Group discounts
     *
     * @param \XLite\Module\CDev\VolumeDiscounts\Model\VolumeDiscount[] $discounts
     *
     * @return array
     */
    protected function groupDiscounts($discounts)
    {
        $result = array();

        foreach ($discounts as $discount) {
            $vendorId = $discount->getVendor() ? $discount->getVendor()->getProfileId() : 0;
            $membershipId = $discount->getMembership() ? $discount->getMembership()->getMembershipId() : 0;
            $result[$vendorId . '-' . $membershipId][] = $discount;
        }

        return array_values($result);
    }
}
