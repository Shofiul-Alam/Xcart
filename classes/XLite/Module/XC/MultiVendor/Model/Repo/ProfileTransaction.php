<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\Repo;

/**
 * ProfileTransaction repository
 */
class ProfileTransaction extends \XLite\Model\Repo\ARepo
{

    const P_PROFILE         = 'profile';
    const P_DATE_RANGE      = 'dateRange';
    const P_DESC_SUBSTR     = 'descSubstr';
    
    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param array                      $value        Condition data
     *
     * @return void
     */
    protected function prepareCndProfile(\Doctrine\ORM\QueryBuilder $queryBuilder, $value)
    {
        if ($value) {
            $queryBuilder
                ->andWhere('p.profile = :profile')
                ->setParameter('profile', $value);
        }
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param integer                    $value        Condition data
     *
     * @return void
     */
    protected function prepareCndDateRange(\Doctrine\ORM\QueryBuilder $queryBuilder, $value)
    {
        if ($value && is_array($value)) {
            list($start, $end) = $value;

            if ($start) {
                $startDate = new \DateTime();
                $startDate->setTimestamp($start);
                $queryBuilder->andWhere('p.date >= :start')
                    ->setParameter('start', $startDate);
            }

            if ($end) {
                $endDate = new \DateTime();
                $endDate->setTimestamp($end);
                $queryBuilder->andWhere('p.date <= :end')
                    ->setParameter('end', $endDate);
            }
        }
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param array                      $value        Condition data
     *
     * @return void
     */
    protected function prepareCndDescSubstr(\Doctrine\ORM\QueryBuilder $queryBuilder, $value)
    {
        return $queryBuilder
            ->andWhere('p.description LIKE :descPattern')
            ->setParameter('descPattern', '%' . $value . '%');
    }

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
        $queryBuilder = $this->defineGetSearchTotalQuery($cnd);
        return $queryBuilder->getResult();
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
        $this->searchState['queryBuilder'] = $this->createQueryBuilder()
            ->linkInner('p.profile', 'profile')
            ->select('ABS(SUM(case when p.value < 0 then p.value else 0 end)) as debit_total')
            ->addSelect('ABS(SUM(case when p.value > 0 then p.value else 0 end)) as credit_total');

        $this->searchState['currentSearchCnd'] = $cnd;

        foreach ($this->searchState['currentSearchCnd'] as $key => $value) {
            if (self::P_LIMIT == $key) {
                continue;
            }
            if (self::P_DATE_RANGE == $key && $value) {
                list($start, $end) = \XLite\View\FormField\Input\Text\DateRange::convertToArray($value);
                $value = \XLite\View\FormField\Input\Text\DateRange::convertToArray($value);
                $subQuery = $this->prepareTotalBeforeRange(
                    $this->searchState['queryBuilder'],
                    $this->searchState['currentSearchCnd']->{self::P_PROFILE},
                    $start
                );

                $this->searchState['queryBuilder']->addSelect(
                    '('. $subQuery . ') as before_total'
                );
            }
            $this->callSearchConditionHandler($value, $key);
        }

        return $this->searchState['queryBuilder'];
    }

    /**
     * Prepare certain search condition
     *
     * @param string   $profile     Profile condition
     * @param string   $dateStart   Date condition
     *
     * @return void
     */
    protected function prepareTotalBeforeRange($queryBuilder, $profile, $dateStart)
    {
        $dateStartObject = new \DateTime();
        $dateStartObject->setTimestamp($dateStart);
        $query = $this->createQueryBuilder('dateRangeProducts')
            ->select('SUM(dateRangeProducts.value)')
            ->where('dateRangeProducts.date < :dateStartTotal');
        $queryBuilder->setParameter('dateStartTotal', $dateStartObject);

        if ($profile) {
            $query
                ->andWhere('dateRangeProducts.profile = :profileTotal');
            $queryBuilder->setParameter('profileTotal', $profile);
        }

        return $query->getDQL();

    }

    // }}}

    /**
     * Assemble regular fields from record
     *
     * @param array $record  Record
     * @param array $regular Regular fields info OPTIONAL
     *
     * @return array
     */
    protected function assembleRegularFieldsFromRecord(array $record, array $regular = array())
    {
        $datetime = null;

        if (isset($record['date']) && is_numeric($record['date'])) {
            $datetime = new \DateTime();
            $datetime->setTimestamp($record['date']);

        } elseif(isset($record['date']) && is_string($record['date'])) {
            $datetime = new \DateTime($record['date']);
        }

        if ($datetime !== null) {
            $record['date'] = $datetime;
        }

        return parent::assembleRegularFieldsFromRecord($record, $regular);
    }
}
