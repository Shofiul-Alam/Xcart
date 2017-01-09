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
 * Order repository
 *
 * @Decorator\Before("XC\NotFinishedOrders")
 */
class Order extends \XLite\Model\Repo\Order implements \XLite\Base\IDecorator
{
    /**
     * Allowable search params
     */
    const P_VENDOR_ID       = 'vendorId';
    const P_VENDOR          = 'vendor';
    const P_COMMISSION_MODE = 'commissionMode';
    const P_PRODUCT         = 'product';

    protected $statisticMode = false;

    /**
     * Finds an entity by its primary key / identifier.
     *
     * @param integer $id          The identifier.
     * @param integer $lockMode    Lock mode OPTIONAL
     * @param integer $lockVersion Lock version OPTIONAL
     *
     * @return \XLite\Model\AEntity
     */
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        $order = parent::find($id, $lockMode, $lockVersion);

        if ($order
            && \XLite::isAdminZone()
            && Core\Auth::getInstance()->isVendor()
            && !$order->isOfCurrentVendor()
        ) {
            $order = null;
        }

        return $order;
    }

    /**
     * Iterate all models
     *
     * @return \Iterator
     */
    public function iterateAllValidOrdersForRemove()
    {
        return $this->createQueryBuilder()->iterate();
    }

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
            if ($this->statisticMode) {
                $qb->andWhere($qb->getMainAlias() . '.vendor = :vendor')
                    ->setParameter('vendor', $auth->getProfile());
            } else {
                $this->addVendorListCondition($qb, $auth->getProfile());
            }
        } else {
            $qb->andWhere($qb->getMainAlias() . '.orderNumber IS NOT NULL');
        }

        return $qb;
    }

    /**
     * Define remove data iterator query builder
     *
     * @param integer $position Position
     *
     * @return \XLite\Model\QueryBuilder\AQueryBuilder
     */
    protected function defineRemoveDataQueryBuilder($position)
    {
        return $this->createQueryBuilder();
    }

    /**
     * Prepare vendor search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param mixed                      $vendor       Vendor identifier
     *
     * @return void
     */
    public function addVendorListCondition($queryBuilder, $vendor)
    {
        $queryBuilder->linkLeft('o.children')
            ->linkLeft('o.items', 'oi');

        $expr = $queryBuilder->expr();

        $oldOrdersCondition = $expr->andX(
            'children.order_id IS NULL',
            'o.parent IS NULL'
        );

        $warehouseOrdersCondition = $expr->andX(
            'o.parent IS NULL',
            'o.orderNumber IS NOT NULL',
            'children.order_id IS NOT NULL'
        );

        $separateOrdersCondition = $expr->andX(
            'o.parent IS NOT NULL',
            'o.orderNumber IS NOT NULL',
            'children.order_id IS NULL'
        );

        if (null === $vendor) {
            $oldOrdersCondition->add('oi.vendor IS NULL');
            $warehouseOrdersCondition->add('children.vendor IS NULL');
            $separateOrdersCondition->add('o.vendor IS NULL');

        } else {
            $oldOrdersCondition->add('oi.vendor = :vendor');
            $warehouseOrdersCondition->add('children.vendor = :vendor');
            $separateOrdersCondition->add('o.vendor = :vendor');

            $queryBuilder->setParameter('vendor', $vendor);
        }

        $condition = $expr->orX($oldOrdersCondition, $warehouseOrdersCondition, $separateOrdersCondition);
        $queryBuilder->andWhere($condition);
    }

    /**
     * Return count by product
     *
     * @param \XLite\Model\Product $product Product
     *
     * @return integer
     */
    public function getCountByProduct($product)
    {
        $qb = parent::createQueryBuilder();
        $this->prepareCndProduct($qb, $product);

        return (int) $qb->select('COUNT(o.order_id)')->getSingleScalarResult();
    }

    /**
     * Prepare vendor search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param integer|null               $vendorId     Vendor identifier
     *
     * @return void
     */
    protected function prepareCndVendorId(\Doctrine\ORM\QueryBuilder $queryBuilder, $vendorId)
    {
        if ($vendorId) {
            $vendorId = Repo\Profile::ADMIN_VENDOR_FAKE_ID === (int) $vendorId
                ? null
                : $vendorId;

            $this->addVendorListCondition($queryBuilder, $vendorId);
        }
    }

    /**
     * Prepare vendor search condition
     * todo: revise
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param mixed                      $vendor       Vendor identifier
     *
     * @throws \InvalidArgumentException
     *
     * @return void
     */
    protected function prepareCndVendor(\Doctrine\ORM\QueryBuilder $queryBuilder, $vendor)
    {
        if ($vendor) {
            $queryBuilder->linkLeft('o.children')
                ->linkLeft('o.items', 'oi')
                ->linkLeft('o.vendor')
                ->linkLeft('vendor.vendor', 'vendorInfo')
                ->linkLeft('vendorInfo.translations', 'vendorInfoTranslations')
                ->linkLeft('children.vendor', 'childVendor')
                ->linkLeft('childVendor.vendor', 'childVendorInfo')
                ->linkLeft('childVendorInfo.translations', 'childVendorInfoTranslations')
                ->linkLeft('oi.vendor', 'itemVendor')
                ->linkLeft('itemVendor.vendor', 'itemVendorInfo')
                ->linkLeft('itemVendorInfo.translations', 'itemVendorInfoTranslations');

            $condition = $queryBuilder->expr()->orX();
            $condition->add($queryBuilder->expr()->like('vendorInfoTranslations.companyName', ':vendorTerm'));
            $condition->add($queryBuilder->expr()->like('vendor.login', ':vendorTerm'));
            $condition->add($queryBuilder->expr()->like('childVendorInfoTranslations.companyName', ':vendorTerm'));
            $condition->add($queryBuilder->expr()->like('childVendor.login', ':vendorTerm'));
            $condition->add($queryBuilder->expr()->like('itemVendorInfoTranslations.companyName', ':vendorTerm'));
            $condition->add($queryBuilder->expr()->like('itemVendor.login', ':vendorTerm'));

            $queryBuilder->andWhere($condition)
                ->setParameter('vendorTerm', sprintf('%%%s%%', $vendor));
        }
    }

    /**
     * Prepare commission mode search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param string                     $mode         Mode
     *
     * @return void
     */
    protected function prepareCndCommissionMode(\Doctrine\ORM\QueryBuilder $queryBuilder, $mode)
    {
        if (in_array($mode, array('manual', 'automatic'), true)) {
            $queryBuilder->linkLeft('o.commission', 'commission');
            $queryBuilder->linkLeft('o.children', 'children');
            $queryBuilder->innerJoin('children.commission', 'childCommission');
        }

        switch ($mode) {
            case 'manual':
                $condition = $queryBuilder->expr()->orX();
                $condition->add('commission.auto = 0');
                $condition->add('childCommission.auto = 0');
                $queryBuilder->andWhere($condition);
                break;
            case 'automatic':
                $condition = $queryBuilder->expr()->orX();
                $condition->add('commission.auto = true');
                $condition->add('childCommission.auto = true');
                $queryBuilder->andWhere($condition);
                break;
        }
    }

    /**
     * Prepare product search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param mixed                      $product      Product
     *
     * @return void
     */
    protected function prepareCndProduct(\Doctrine\ORM\QueryBuilder $queryBuilder, $product)
    {
        $queryBuilder->linkLeft('o.items', 'oi')
            ->andWhere('oi.object = :product')
            ->setParameter('product', $product);
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param array                      $value        Condition data
     *
     * @return void
     */
    protected function prepareCndOrderBy(\Doctrine\ORM\QueryBuilder $queryBuilder, array $value)
    {
        list($sort, ) = $this->getSortOrderValue($value);

        if ($sort === 'commissionValue') {
            $this->prepareCndOrderByCommissionValue($queryBuilder);
        }

        parent::prepareCndOrderBy($queryBuilder, $value);
    }

    /**
     * OrderBy commission value
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder QueryBuilder instance
     *
     * @return void
     */
    protected function prepareCndOrderByCommissionValue(\Doctrine\ORM\QueryBuilder $queryBuilder)
    {
        $queryBuilder->linkLeft('o.commission', 'commission');
        $queryBuilder->addSelect('commission.value as commissionValue');
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param integer                    $value        Condition data
     *
     * @return void
     */
    protected function prepareCndSku(\Doctrine\ORM\QueryBuilder $queryBuilder, $value)
    {
        $value = trim($value);

        if (!empty($value)) {

            $multiple = array_filter(array_map('trim', explode(',', $value)), 'strlen');

            if (0 < count($multiple)) {

                $queryBuilder->linkLeft('o.items', 'oi');
                $queryBuilder->linkLeft('o.children');
                $queryBuilder->linkLeft('children.items', 'children_items');

                if (1 < count($multiple)) {
                    // Detectd several values separated with comma: search for exact match
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->in('oi.sku', $multiple),
                            $queryBuilder->expr()->in('children_items.sku', $multiple)
                        )
                    );

                } else {
                    // Detected single SKU value
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->orX(
                            'oi.sku LIKE :sku',
                            'children_items.sku LIKE :sku'
                        )
                    )
                        ->setParameter('sku', '%' . $value . '%');
                }
            }
        }
    }

    // {{{ Statistic

    /**
     * Get orders statistics data: count and sum of orders
     *
     * @param integer $startDate Start date timestamp
     * @param integer $endDate   End date timestamp OPTIONAL
     *
     * @return array
     */
    public function getOrderStats($startDate, $endDate = 0)
    {
        $result = $this->defineGetOrderStatsQuery($startDate, $endDate)->getSingleResult();

        $auth = Core\Auth::getInstance();
        if ($auth->isVendor()) {
            $qb = parent::defineGetOrderStatsQuery($startDate, $endDate);

            $qb->select('COUNT(o.order_id) as orders_count')
                ->addSelect('SUM(oi.total) + SUM(surcharges.value) as orders_total')
                ->linkLeft('o.items', 'oi')
                ->linkLeft('o.surcharges')
                ->andWhere('o.parent IS NULL')
                ->andWhere('oi.vendor = :vendor')
                ->andWhere('surcharges.vendor = :vendor')
                ->setParameter('vendor', $auth->getVendorId());

            $singleResult = $qb->getSingleResult();
            if ($singleResult) {
                $result['orders_count'] += $singleResult['orders_count'];
                $result['orders_total'] += $singleResult['orders_total'];
            }
        }

        return $result;
    }

    /**
     * Returns count statistics
     *
     * @param \XLite\Core\CommonCell $condition Condition
     *
     * @return mixed
     */
    public function getStatisticCount($condition)
    {
        $result = parent::getStatisticCount($condition);

        $vendorId = Core\Auth::getInstance()->isVendor()
            ? Core\Auth::getInstance()->getVendorId()
            : $condition->vendor_id;

        if ($vendorId) {
            $qb = parent::defineStatisticCountQuery($condition);

            $qb->select('COUNT(DISTINCT o)')
                ->addSelect('ps.code')
                ->linkLeft('o.items', 'oi')
                ->andWhere('o.parent IS NULL');

            if (Repo\Profile::ADMIN_VENDOR_FAKE_ID === (int) $vendorId) {
                $qb->linkLeft('o.children')
                    ->andWhere('oi.vendor IS NULL')
                    ->andWhere('children.order_id IS NULL');

            } else {
                $qb->andWhere('oi.vendor = :vendor')
                    ->setParameter('vendor', $vendorId);
            }

            $singleResult = $qb->getResult();
            $result = $this->mergeTotals($result, $singleResult, 'code', 1);
        }

        return $result;
    }

    /**
     * Returns total statistics
     *
     * @param \XLite\Core\CommonCell $condition Condition
     *
     * @return mixed
     */
    public function getStatisticTotal($condition)
    {
        $result = parent::getStatisticTotal($condition);

        $vendorId = Core\Auth::getInstance()->isVendor()
            ? Core\Auth::getInstance()->getVendorId()
            : $condition->vendor_id;

        if ($vendorId) {
            $singleItemsResult = $this->getSingleStatisticItemsTotal($condition, $vendorId);
            $singleSurchargesResult = $this->getSingleStatisticSurchargesTotal($condition, $vendorId);

            $singleResult = $this->mergeTotals($singleItemsResult, $singleSurchargesResult, 'code', 1);
            $result = $this->mergeTotals($result, $singleResult, 'code', 1);
        }

        return $result;
    }

    /**
     * Returns statistic items total for multi vendor single (before 5.2.5) orders
     *
     * @param \XLite\Core\CommonCell $condition Condition
     * @param mixed                  $vendorId  Vendor id
     *
     * @return mixed
     */
    protected function getSingleStatisticItemsTotal($condition, $vendorId)
    {
        $qb = parent::defineStatisticTotalQuery($condition);

        $qb->select('SUM(oi.total)')
            ->addSelect('ps.code')
            ->linkLeft('o.items', 'oi')
            ->andWhere('o.parent IS NULL');

        if (Repo\Profile::ADMIN_VENDOR_FAKE_ID === (int) $vendorId) {
            $qb->linkLeft('o.children')
                ->andWhere('children.order_id IS NULL')
                ->andWhere('oi.vendor IS NULL');

        } else {
            $qb->andWhere('oi.vendor = :vendor')
                ->setParameter('vendor', $vendorId);
        }

        return $qb->getResult();
    }

    /**
     * Returns statistic surcharges total for multi vendor single (before 5.2.5) orders
     *
     * @param \XLite\Core\CommonCell $condition Condition
     * @param mixed                  $vendorId  Vendor id
     *
     * @return mixed
     */
    protected function getSingleStatisticSurchargesTotal($condition, $vendorId)
    {
        $qb = parent::defineStatisticTotalQuery($condition);

        $qb->select('SUM(surcharges.value)')
            ->addSelect('ps.code')
            ->linkLeft('o.surcharges')
            ->andWhere('o.parent IS NULL');

        if (Repo\Profile::ADMIN_VENDOR_FAKE_ID === (int) $vendorId) {
            $qb->linkLeft('o.children')
                ->andWhere('children.order_id IS NULL')
                ->andWhere('surcharges.vendor IS NULL');

        } else {
            $qb->andWhere('surcharges.vendor = :vendor')
                ->setParameter('vendor', $vendorId);
        }

        return $qb->getResult();
    }

    /**
     * Create a QueryBuilder instance for getOrderStats()
     *
     * @param integer $startDate Start date timestamp
     * @param integer $endDate   End date timestamp
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function defineGetOrderStatsQuery($startDate, $endDate)
    {
        $this->statisticMode = true;
        $qb = parent::defineGetOrderStatsQuery($startDate, $endDate);
        $this->statisticMode = false;

        return $qb;
    }

    /**
     * Returns query builder for count statistics
     *
     * @param \XLite\Core\CommonCell $condition Condition
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function defineStatisticCountQuery($condition)
    {
        $this->statisticMode = true;
        $queryBuilder = parent::defineStatisticCountQuery($condition);
        $this->statisticMode = false;

        if ($condition->vendor_id
            && !Core\Auth::getInstance()->isVendor()
        ) {
            $vendorId = Repo\Profile::ADMIN_VENDOR_FAKE_ID === (int) $condition->vendor_id
                ? null
                : $condition->vendor_id;

            if ($vendorId || null === $vendorId) {
                if ($vendorId) {
                    $queryBuilder->andWhere('o.vendor = :vendor')
                        ->setParameter('vendor', $vendorId);
                } else {
                    $queryBuilder
                        ->andWhere('o.vendor IS NULL')
                        ->andWhere('o.parent IS NOT NULL');
                }

                $queryBuilder->where(
                    $queryBuilder->expr()->andX()->addMultiple(
                        array_filter($queryBuilder->getDQLPart('where')->getParts(), function ($item) {
                            return $item !== 'o.orderNumber IS NOT NULL';
                        })
                    )
                );
            }
        }

        return $queryBuilder;
    }

    /**
     * Returns query builder for total statistics
     *
     * @param \XLite\Core\CommonCell $condition Condition
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function defineStatisticTotalQuery($condition)
    {
        $this->statisticMode = true;
        $queryBuilder = parent::defineStatisticTotalQuery($condition);
        $this->statisticMode = false;

        if ($condition->vendor_id
            && !Core\Auth::getInstance()->isVendor()
        ) {
            $vendorId = Repo\Profile::ADMIN_VENDOR_FAKE_ID === (int) $condition->vendor_id
                ? null
                : $condition->vendor_id;

            if ($vendorId || null === $vendorId) {
                if ($vendorId) {
                    $queryBuilder->andWhere('o.vendor = :vendor')
                        ->setParameter('vendor', $vendorId);
                } else {
                    $queryBuilder
                        ->andWhere('o.vendor IS NULL')
                        ->andWhere('o.parent IS NOT NULL');
                }

                $queryBuilder->where(
                    $queryBuilder->expr()->andX()->addMultiple(
                        array_filter($queryBuilder->getDQLPart('where')->getParts(), function ($item) {
                            return $item !== 'o.orderNumber IS NOT NULL';
                        })
                    )
                );
            }
        }

        return $queryBuilder;
    }

    // }}}

    // {{{ Search totals

    /**
     * Returns search totals
     *
     * @param \XLite\Core\CommonCell $cnd Search condition
     *
     * @return array
     */
    public function getSearchTotal(\XLite\Core\CommonCell $cnd)
    {
        $result = parent::getSearchTotal($cnd);
        $auth = Core\Auth::getInstance();

        if ($auth->isVendor()) {
            $singleItemsResult = $this->getSingleSearchItemsTotal($cnd, $auth->getVendorId());
            $singleSurchargesResult = $this->getSingleSearchSurchargesTotal($cnd, $auth->getVendorId());
            $singleResult
                = $this->mergeTotals($singleItemsResult, $singleSurchargesResult, 'currency_id', 'orders_total');

            $result = $this->mergeTotals($result, $singleResult, 'currency_id', 'orders_total');
        }

        return $result;
    }

    /**
     * getSingleSearchItemsTotal
     *
     * @param \XLite\Core\CommonCell $cnd      Search condition
     * @param integer                $vendorId Vendor id
     *
     * @return mixed
     */
    protected function getSingleSearchItemsTotal($cnd, $vendorId)
    {
        $qb = parent::defineGetSearchTotalQuery($cnd);

        $qb->select('c.currency_id as currency_id')
            ->addSelect('SUM(oi.total) as orders_total')
            ->linkLeft('o.items', 'oi')
            ->andWhere('o.parent IS NULL');

        if (Repo\Profile::ADMIN_VENDOR_FAKE_ID === (int) $vendorId) {
            $qb->linkLeft('o.children')
                ->andWhere('children.order_id IS NULL')
                ->andWhere('oi.vendor IS NULL');

        } else {
            $qb->andWhere('oi.vendor = :vendor')
                ->setParameter('vendor', $vendorId);
        }

        return $qb->getResult();
    }

    /**
     * getSingleSearchSurchargesTotal
     *
     * @param \XLite\Core\CommonCell $cnd      Search condition
     * @param integer                $vendorId Vendor id
     *
     * @return mixed
     */
    protected function getSingleSearchSurchargesTotal($cnd, $vendorId)
    {
        $qb = parent::defineGetSearchTotalQuery($cnd);

        $qb->select('c.currency_id as currency_id')
            ->addSelect('SUM(surcharges.value) as orders_total')
            ->linkLeft('o.surcharges')
            ->andWhere('o.parent IS NULL');

        if (Repo\Profile::ADMIN_VENDOR_FAKE_ID === (int) $vendorId) {
            $qb->linkLeft('o.children')
                ->andWhere('children.order_id IS NULL')
                ->andWhere('surcharges.vendor IS NULL');

        } else {
            $qb->andWhere('surcharges.vendor = :vendor')
                ->setParameter('vendor', $vendorId);
        }

        return $qb->getResult();
    }

    /**
     * Create a QueryBuilder instance for getSearchTotals()
     *
     * @param \XLite\Core\CommonCell $cnd Search condition
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function defineGetSearchTotalQuery(\XLite\Core\CommonCell $cnd)
    {
        if ($cnd->{static::P_VENDOR} && $cnd->{static::P_VENDOR_ID}
            && !Core\Auth::getInstance()->isVendor()
        ) {
            unset($cnd->{static::P_VENDOR});
        }

        $this->statisticMode = true;
        $queryBuilder = parent::defineGetSearchTotalQuery($cnd);
        $this->statisticMode = false;

        return $queryBuilder;
    }

    /**
     * Returns earnings search totals
     *
     * @param \XLite\Core\CommonCell $cnd Search condition
     *
     * @return array
     */
    public function getEarningsSearchTotal(\XLite\Core\CommonCell $cnd)
    {
        $parentResult = $this->defineGetSearchTotalQuery($cnd)
            ->linkLeft('o.commission', 'commission')
            ->addSelect('SUM(commission.value) as earnings_total')
            ->addSelect('SUM(o.total) as vendors_total')
            ->andWhere('commission.id IS NOT NULL')
            ->getQuery()->getResult();

        $childrenResult = $this->defineGetSearchTotalQuery($cnd)
            ->linkLeft('o.children', 'children2', 'WITH', 'children2.vendor IS NOT NULL')
            ->innerJoin('children2.commission', 'childrencommission')
            ->addSelect('SUM(childrencommission.value) as earnings_total')
            ->addSelect('SUM(children2.total) as vendors_total')
            ->andWhere('childrencommission.id IS NOT NULL')
            ->getQuery()->getResult();

        $resultVendorsTotal = $this->mergeTotals($parentResult, $childrenResult, 'currency_id', 'vendors_total');
        $result = $this->mergeTotals($parentResult, $childrenResult, 'currency_id', 'earnings_total');

        if (isset($result[0]['vendors_total'], $resultVendorsTotal[0]['vendors_total'])) {
            $result[0]['vendors_total'] = $resultVendorsTotal[0]['vendors_total'];
        }

        return $result;
    }

    // }}}

    /**
     * Merge total arrays
     *
     * @param array  $a                 Array to merge
     * @param array  $b                 Array to merge
     * @param string $identificationKey Identification key
     * @param string $valueKey          Value key
     *
     * @return array
     */
    protected function mergeTotals($a, $b, $identificationKey, $valueKey)
    {
        foreach ($b as $total) {
            $index = false;

            foreach ($a as $k => $v) {
                if ($v[$identificationKey] === $total[$identificationKey]) {
                    $index = $k;

                    break;
                }
            }

            if (false !== $index) {
                $a[$index][$valueKey] += $total[$valueKey];

            } else {
                $a[] = $total;
            }
        }

        return $a;
    }
}
