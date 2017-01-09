<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\Repo\Shipping;

use XLite\Core;
use XLite\Model\Repo;

/**
 * Shipping method model
 */
class Method extends \XLite\Model\Repo\Shipping\Method implements \XLite\Base\IDecorator
{
    /**
     * Allowable search params
     */
    const P_VENDOR_ID = 'vendorId';
    const P_VENDOR    = 'vendor';

    /**
     * Returns online carrier by processor id
     *
     * @param string               $processorId Processor id
     * @param \XLite\Model\Profile $vendor      Vendor
     *
     * @return null|\XLite\Model\AEntity
     */
    public function findOnlineCarrierByVendor($processorId, $vendor)
    {
        $qb = $this->defineFindOnlineCarrier($processorId);
        $this->prepareCndVendor($qb, $vendor);

        return $qb->getSingleResult();
    }

    /**
     * Returns online carrier by processor id
     *
     * @param \XLite\Model\Profile $vendor Vendor
     *
     * @return null|\XLite\Model\AEntity
     */
    public function findOnlineCarriersByVendor($vendor)
    {
        $qb = $this->defineFindOnlineCarriers();
        $this->prepareCndVendor($qb, $vendor);

        return $qb->getResult();
    }

    /**
     * Returns shipping methods by specified processor Id
     *
     * @param string               $processorId Processor Id
     * @param \XLite\Model\Profile $vendor      Vendor
     * @param boolean              $enabledOnly Flag: Get only enabled methods (true) or all methods (false) OPTIONAL
     *
     * @return \Doctrine\ORM\PersistentCollection
     */
    public function findMethodsByProcessorAndVendor($processorId, $vendor, $enabledOnly = true)
    {
        $qb = $this->defineFindMethodsByProcessor($processorId, $enabledOnly);
        $this->prepareCndVendor($qb, $vendor);

        return $qb->getResult();
    }

    /**
     * Returns allowed fields and flag required/optional
     *
     * @return array
     */
    protected function getAllowedFields()
    {
        $list = parent::getAllowedFields();
        $list['vendor'] = 0;

        return $list;
    }

    /**
     * Prepare vendor search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param integer|null               $value        Value
     *
     * @return void
     */
    protected function prepareCndVendorId(\Doctrine\ORM\QueryBuilder $queryBuilder, $value)
    {
        if (null === $value) {
            $queryBuilder->andWhere('m.vendor IS NULL');

        } else {
            $queryBuilder->andWhere('m.vendor = :vendor')
                ->setParameter('vendor', $value);
        }
    }

    /**
     * Prepare vendor search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param \XLite\Model\Profile|null  $value        Value
     *
     * @return void
     */
    protected function prepareCndVendor(\Doctrine\ORM\QueryBuilder $queryBuilder, $value)
    {
        if (null === $value) {
            $queryBuilder->andWhere('m.vendor IS NULL');

        } else {
            $queryBuilder->andWhere('m.vendor = :vendor')
                ->setParameter('vendor', $value);
        }
    }
}
