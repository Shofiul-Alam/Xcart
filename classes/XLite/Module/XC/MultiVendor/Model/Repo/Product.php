<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\Repo;

use XLite\Core;
use XLite\Model;
use XLite\Model\Repo;
use XLite\Module\XC\ProductFilter;

/**
 * The "product" model repository
 */
class Product extends \XLite\Model\Repo\Product implements \XLite\Base\IDecorator
{
    /**
     * Allowable search params
     */
    const P_VENDOR_ID = 'vendorId';
    const P_VENDOR    = 'vendor';
    const P_VENDORS   = 'vendors';

    /**
     * Flag indicating whether per-vendor filtering is enabled for products in admin area
     *
     * @var boolean
     */
    protected $enableVendorCondition = true;

    /**
     * Create a new QueryBuilder instance that is pre-populated for this entity name
     *
     * @param string $alias   Table alias OPTIONAL
     * @param string $indexBy The index for the from. OPTIONAL
     * @param string $code    Language code OPTIONAL
     *
     * @return \XLite\Model\QueryBuilder\AQueryBuilder
     */
    public function createQueryBuilder($alias = null, $indexBy = null, $code = null)
    {
        $queryBuilder = parent::createQueryBuilder($alias, $indexBy, $code);

        if ($this->enableVendorCondition && \XLite::isAdminZone()) {
            $this->addVendorCondition($queryBuilder);
        }

        $queryBuilder->linkLeft('p.vendor');

        if (!\XLite::isAdminZone()) {
            $queryBuilder->andWhere('p.vendor is null OR vendor.status = :profileEnabled')
                ->setParameter('profileEnabled', Model\Profile::STATUS_ENABLED);
        }

        return $queryBuilder;
    }

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

        if ($this->enableVendorCondition && \XLite::isAdminZone()) {
            $this->addVendorCondition($queryBuilder);
        }

        return $queryBuilder;
    }

    /**
     * Finds an entity by its primary key / identifier.
     *
     * @param integer $id          The identifier.
     * @param integer $lockMode    Lock mode OPTIONAL
     * @param integer $lockVersion Lock version OPTIONAL
     *
     * @return object The entity.
     */
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        $product = parent::find($id, $lockMode, $lockVersion);

        if ($product
            && $this->enableVendorCondition
            && \XLite::isAdminZone()
            && Core\Auth::getInstance()->isVendor()
            && !$product->isOfCurrentVendor()
        ) {
            $product = null;
        }

        return $product;
    }

    /**
     * Finds entities by a set of criteria.
     *
     * @param array   $criteria Search criteria
     * @param array   $orderBy  Order by expressions OPTIONAL
     * @param integer $limit    Entity limit OPTIONAL
     * @param integer $offset   First entity offset OPTIONAL
     *
     * @return array The objects.
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $auth = Core\Auth::getInstance();

        if ($this->enableVendorCondition && \XLite::isAdminZone() && $auth->isVendor()) {
            $criteria += array('vendor' => $auth->getVendorId());
        }

        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Finds a single entity by a set of criteria.
     *
     * @param array $criteria Search criteria
     *
     * @return object
     */
    public function findOneBy(array $criteria)
    {
        $auth = Core\Auth::getInstance();

        if ($this->enableVendorCondition && \XLite::isAdminZone() && $auth->isVendor()) {
            $criteria += array('vendor' => $auth->getVendorId());
        }

        return parent::findOneBy($criteria);
    }

    /**
     * Get all vendors of a collection of products
     * (including the special null-vendor - it is the admin)
     *
     * @param \XLite\Core\CommonCell $cnd Search condition
     *
     * @return array
     */
    public function getVendors(\XLite\Core\CommonCell $cnd)
    {
        $queryBuilder = $this->createQueryBuilder('p');
        $this->searchState['currentSearchCnd'] = $cnd;

        foreach ($this->searchState['currentSearchCnd'] as $key => $value) {
            $this->callSearchConditionHandler($value, $key, $queryBuilder, false);
        }

        $products = $queryBuilder->linkLeft('p.vendor')
            ->groupBy('p.vendor')
            ->orderBy('p.product_id')
            ->select('p, vendor')
            ->getResult();

        $vendors = array_map(function ($p) {
            return $p->getVendor();
        }, $products);

        usort($vendors, function ($a, $b) {
            return ($a && $b)
                ? strcmp($a->getName(), $b->getName())
                : (!$a ? -1 : 1);
        });

        return $vendors;
    }

    /**
     * Get all vendors of current category of products
     *
     * @return array
     */
    public function getCurrentCategoryVendors()
    {
        $itemList = new ProductFilter\View\ItemsList\Product\Customer\Category\CategoryFilter;

        return $this->getVendors($itemList->getSearchCondition());
    }

    /**
     * Filters products by the current vendor (if applicable)
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder object
     *
     * @return void
     */
    protected function addVendorCondition(\Doctrine\ORM\QueryBuilder $queryBuilder)
    {
        $auth = Core\Auth::getInstance();

        if ($auth->isVendor()) {
            $queryBuilder->andWhere('p.vendor = :vendorId')
                ->setParameter('vendorId', $auth->getVendorId());
        }
    }

    /**
     * Enables product filtering by vendor (for the next query builder returned by createQueryBuilder)
     *
     * @return void
     */
    public function enableVendorCondition()
    {
        $this->enableVendorCondition = true;
    }

    /**
     * Disables product filtering by vendor (for the next query builder returned by createQueryBuilder)
     *
     * @return void
     */
    public function disableVendorCondition()
    {
        $this->enableVendorCondition = false;
    }

    /**
     * Prepare vendor search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param integer                    $vendorId     Vendor identifier
     *
     * @return void
     */
    protected function prepareCndVendorId(\Doctrine\ORM\QueryBuilder $queryBuilder, $vendorId)
    {
        if (0 < $vendorId) {
            $queryBuilder->andWhere('p.vendor = :vendorId')
                ->setParameter('vendorId', $vendorId);

        } elseif (Repo\Profile::ADMIN_VENDOR_FAKE_ID == $vendorId) {
            $queryBuilder->andWhere('p.vendor IS NULL');
        }
    }

    /**
     * Prepare vendor search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param mixed                      $vendor       Vendor identifier
     *
     * @return void
     */
    protected function prepareCndVendor(\Doctrine\ORM\QueryBuilder $queryBuilder, $vendor)
    {
        if ($vendor) {
            $condition = $queryBuilder->expr()->orX();
            $condition->add($queryBuilder->expr()->like('vendorInfoTranslations.companyName', ':vendorTerm'));
            $condition->add($queryBuilder->expr()->like('vendor.login', ':vendorTerm'));

            $queryBuilder->linkLeft('p.vendor')
                ->linkLeft('vendor.vendor', 'vendorInfo')
                ->linkLeft('vendorInfo.translations', 'vendorInfoTranslations')
                ->andWhere($condition)
                ->setParameter('vendorTerm', sprintf('%%%s%%', $vendor));
        }
    }

    /**
     * Prepare vendor search condition
     *
     * @param \Doctrine\ORM\QueryBuilder                         $queryBuilder Query builder to prepare
     * @param \Doctrine\Common\Collections\ArrayCollection|array $vendors      Vendor identifier
     *
     * @return void
     */
    protected function prepareCndVendors(\Doctrine\ORM\QueryBuilder $queryBuilder, $vendors)
    {
        if (is_array($vendors)) {
            $hasNoVendor = false;

            foreach ($vendors as $k => $vendor) {
                if (!$vendor) {
                    $hasNoVendor = true;
                    unset($vendors[$k]);
                }
            }

            if ($hasNoVendor || !empty($vendors)) {
                $cnd = $queryBuilder->expr()->orX();

                if ($hasNoVendor) {
                    $cnd->add('p.vendor IS NULL');
                }

                if (!empty($vendors)) {
                    if (1 < count($vendors)) {
                        $cnd->add($queryBuilder->expr()->in('p.vendor', $vendors));

                    } else {
                        $cnd->add('p.vendor = :oneVendor');
                        $queryBuilder->setParameter('oneVendor', array_pop($vendors));
                    }
                }

                $queryBuilder->andWhere($cnd);
            }
        }
    }

    /**
     * Get identifiers list for specified query builder object
     *
     * @param \Doctrine\ORM\QueryBuilder $qb    Query builder
     * @param string                     $name  Name
     * @param mixed                      $value Value
     *
     * @return void
     */
    protected function addImportCondition(\Doctrine\ORM\QueryBuilder $qb, $name, $value)
    {
        if ('vendor' === $name) {
            $auth = Core\Auth::getInstance();
            if ($auth->isVendor()) {
                $value = $auth->getVendor()->getLogin();
            }

            if ($value) {
                $qb->linkLeft('p.vendor')
                    ->andWhere('vendor.login = :vendorLogin')
                    ->setParameter('vendorLogin', $value);

            } else {
                $qb->andWhere('p.vendor IS NULL');
            }

        } else {
            parent::addImportCondition($qb, $name, $value);
        }
    }
}
