<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\Reviews\Model\Repo;

/**
 * Review model repository extension
 *
 * @Decorator\Depend ("XC\Reviews")
 */
class Review extends \XLite\Module\XC\Reviews\Model\Repo\Review implements \XLite\Base\IDecorator
{
    /**
     * Search params
     */
    const SEARCH_VENDOR_LOGIN = 'vendorLogin';
    const SEARCH_VENDOR       = 'vendor';
    const SEARCH_VENDOR_ID    = 'vendorId';

    /**
     * Create a new QueryBuilder instance that is prepopulated for this entity name
     * NOTE: without any relative subqueries!
     *
     * @param string $alias Table alias OPTIONAL
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createPureQueryBuilder($alias = null)
    {
        $queryBuilder = parent::createPureQueryBuilder($alias);

        $vendor = \XLite\Core\Auth::getInstance()->getVendor();
        if ($vendor && \XLite::isAdminZone()) {
            $queryBuilder->linkLeft('r.product')
                ->andWhere('product.vendor = :vendor')
                ->setParameter('vendor', $vendor);
        }

        return $queryBuilder;
    }

    /**
     * Prepare conditions for search
     *
     * @return void
     */
    protected function processConditions()
    {
        $auth = \XLite\Core\Auth::getInstance();

        if (\XLite::isAdminZone() && $auth->isVendor()) {
            $this->searchState['currentSearchCnd']->{static::SEARCH_VENDOR_LOGIN} = $auth->getVendor()->getLogin();
        }

        parent::processConditions();
    }

    /**
     * Search average rating
     *
     * @param \XLite\Core\CommonCell $cnd Search condition
     *
     * @return \Doctrine\ORM\PersistentCollection|integer
     */
    public function searchAverageRating(\XLite\Core\CommonCell $cnd)
    {
        $queryBuilder = $this->createQueryBuilder('r');
        $this->currentSearchCnd = $cnd;

        $countOnly = false;

        foreach ($this->currentSearchCnd as $key => $value) {
            $this->callSearchConditionHandler($value, $key, $queryBuilder, $countOnly);
        }

        $queryBuilder->select('AVG(r.rating)');

        return $queryBuilder->getSingleScalarResult();
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param array|string               $value        Condition data
     * @param boolean                    $countOnly    "Count only" flag. Do not need to add "order by" clauses
     *                                                 if only count is needed.
     *
     * @return void
     */
    protected function prepareCndVendorLogin(\Doctrine\ORM\QueryBuilder $queryBuilder, $value, $countOnly)
    {
        $queryBuilder->linkLeft('r.product', 'product');
        $queryBuilder->linkLeft('product.vendor', 'vendor');

        if (!empty($value)) {
            $queryBuilder->andWhere('vendor.login = :vendorLogin')
                ->setParameter('vendorLogin', $value);

        } else {
            $queryBuilder->andWhere('product.vendor is null');
        }
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param array|string               $value        Condition data
     * @param boolean                    $countOnly    "Count only" flag. Do not need to add "order by" clauses
     *                                                 if only count is needed.
     *
     * @return void
     */
    protected function prepareCndVendorId(\Doctrine\ORM\QueryBuilder $queryBuilder, $value, $countOnly)
    {
        $queryBuilder->linkLeft('r.product', 'product');
        $queryBuilder->linkLeft('product.vendor', 'vendor');

        if (0 < $value) {
            $queryBuilder->andWhere('product.vendor = :vendorId')
                ->setParameter('vendorId', $value);

        } elseif (\XLite\Model\Repo\Profile::ADMIN_VENDOR_FAKE_ID == $value) {
            $queryBuilder->andWhere('product.vendor IS NULL');
        }
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param array|string               $value        Condition data
     * @param boolean                    $countOnly    "Count only" flag. Do not need to add "order by" clauses
     *                                                 if only count is needed.
     *
     * @return void
     */
    protected function prepareCndVendor(\Doctrine\ORM\QueryBuilder $queryBuilder, $value, $countOnly)
    {
        if ($value) {
            $queryBuilder->linkLeft('r.product')
                ->linkLeft('product.vendor')
                ->linkLeft('vendor.vendor', 'vendorInfo')
                ->linkLeft('vendorInfo.translations', 'vendorInfoTranslations');

            $condition = $queryBuilder->expr()->orX();
            $condition->add($queryBuilder->expr()->like('vendorInfoTranslations.companyName', ':vendorTerm'));
            $condition->add($queryBuilder->expr()->like('vendor.login', ':vendorTerm'));

            $queryBuilder->andWhere($condition)
                ->setParameter('vendorTerm', sprintf('%%%s%%', $value));
        }
    }
}
