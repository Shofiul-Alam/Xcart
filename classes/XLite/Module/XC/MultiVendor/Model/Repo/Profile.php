<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\Repo;

use XLite\Model;
use XLite\Module\XC\MultiVendor;

/**
 * The Profile model repository
 */
class Profile extends \XLite\Model\Repo\Profile implements \XLite\Base\IDecorator
{
    /**
     * Surrogate vendor ID for products not having a vendor (created by admin)
     */
    const ADMIN_VENDOR_FAKE_ID = -1;

    const ADD_TOTALS = 'addTotals';

    /**
     * Find all vendors
     *
     * @param boolean                $countOnly Return items list or only its size OPTIONAL
     *
     * @return array
     */
    public function findAllVendors($countOnly = false)
    {
        $this->searchState['queryBuilder'] = $this->createQueryBuilder('p');

        $this->searchState['queryBuilder']->bindRegistered()->bindVendor();

        if (!\XLite::isAdminZone()) {
            $this->searchState['queryBuilder']->bindAndCondition('p.status', Model\Profile::STATUS_ENABLED);
        }
        $result = $countOnly
            ? $this->searchCount()
            : $this->searchResult();

        if (!$countOnly) {
            $vendorNames = array_map(
                function($vendor){
                    return $vendor->getVendorCompanyName();
                },
                $result
            );
            $toSort = array_combine($vendorNames, array_values($result));
            ksort($toSort);

            $result = array_values($toSort);
            unset($toSort);
        }


        return $result;
    }

    /**
     * Gets amount of unapproved vendors
     *
     * @return array
     */
    public function getUnapprovedVendorsAmount()
    {
        $queryBuilder = $this->createQueryBuilder('p');

        $queryBuilder->bindRegistered()->bindVendor();

        $queryBuilder->bindAndCondition('p.status', MultiVendor\Model\Profile::STATUS_UNAPPROVED_VENDOR);
        $queryBuilder->select($queryBuilder->expr()->count('p'));

        $vendorsQty = $queryBuilder->getQuery()->getSingleScalarResult();

        return $vendorsQty;
    }

    /**
     * Define query builder for search users by term
     *
     * @param string  $term  Term
     * @param integer $limit Limit OPTIONAL
     *
     * @return \XLite\Model\QueryBuilder\AQueryBuilder
     */
    protected function defineFindProfilesByTerm($term, $limit = null)
    {
        $qb = parent::defineFindProfilesByTerm($term, $limit);

        if (\XLite\Core\Auth::getInstance()->isVendor() && \XLite\Core\Config::getInstance()->XC->MultiVendor->mask_contacts) {
            $qb->linkInner('\XLite\Model\Order', 'po', 'WITH', 'po.orig_profile = p AND po.vendor = :vendor')
                ->setParameter('vendor', \XLite\Core\Auth::getInstance()->getProfile());
        }

        return $qb;
    }

    // {{{ findVendorsByTerm

    /**
     * Find vendors by term
     *
     * @param string  $term  Term
     * @param integer $limit Limit OPTIONAL
     *
     * @return array
     */
    public function findVendorsByTerm($term, $limit = null)
    {
        $queryBuilder = $this->defineFindVendorsByTerm($term, $limit);

        return $queryBuilder->getOnlyEntities();
    }

    /**
     * define query builder for search vendors by term
     *
     * @param string  $term  Term
     * @param integer $limit Limit OPTIONAL
     *
     * @return array
     */
    protected function defineFindVendorsByTerm($term, $limit = null)
    {
        $queryBuilder = $this->createQueryBuilder();

        $queryBuilder->bindRegistered()->bindVendor()
            ->linkLeft('p.vendor');

        $queryBuilder = \XLite\Core\Database::getRepo('XLite\Module\XC\MultiVendor\Model\Vendor')
            ->linkTranslation($queryBuilder, 'vendor');


        $condition = $queryBuilder->expr()->orX();
        $condition->add($queryBuilder->expr()->like('vendorTranslation.companyName', ':vendorTerm'));
        $condition->add($queryBuilder->expr()->like('p.login', ':vendorTerm'));

        $queryBuilder->andWhere($condition)
            ->setParameter('vendorTerm', sprintf('%%%s%%', $term))
            ->orderBy('vendorTranslation.companyName', 'asc');

        if ($limit) {
            $queryBuilder->setMaxResults($limit);
        }

        return $queryBuilder;
    }

    /**
     * prepareCndOrderBy
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder QueryBuilder instance
     * @param boolean                      $value        Should apply
     *
     * @return void
     */
    protected function prepareCndAddTotals(\Doctrine\ORM\QueryBuilder $queryBuilder, $value)
    {
        if ($value
            && isset($this->searchState['searchMode'])
            && $this->searchState['searchMode'] !== static::SEARCH_MODE_COUNT
        ) {
            $queryBuilder->linkLeft('p.profileTransactions', 'pt')
                ->addSelect('SUM(pt.value) as hidden balance')
                ->addSelect('ABS(SUM(case when pt.value < 0 then pt.value else 0 end)) as hidden debit_total')
                ->addSelect('ABS(SUM(case when pt.value > 0 then pt.value else 0 end)) as hidden credit_total')
                ->groupBy('p.profile_id');
        }
    }

    // }}}
}
