<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\Repo;

use XLite\Core;

/**
 * DB-based configuration registry
 */
class Config extends \XLite\Model\Repo\Config implements \XLite\Base\IDecorator
{
    /**
     * Get the list of all options
     *
     * @param \XLite\Model\Profile $vendor Vendor
     * @param boolean              $force  Do not use cache OPTIONAL
     *
     * @return array
     */
    public function getAllVendorOptions(\XLite\Model\Profile $vendor, $force = false)
    {
        $data = null;
        $key = 'all-' . $vendor->getProfileId();

        if (!$force) {
            $data = $this->getFromCache($key);
        }

        if (null === $data) {
            $data = $this->defineAllVendorOptionsQuery($vendor)->getResult();
            $data = $this->detachList($data);
            $data = $this->processOptions($data);
            $this->saveToCache($data, $key);
        }

        return $data;
    }

    /**
     * Create new option / Update option value
     *
     * @param array $data Option data in the following format
     *
     * @return void
     * @throws \Exception
     */
    public function createOption($data)
    {
        $vendor = Core\Auth::getInstance()->getVendor();
        if ($vendor) {
            $data['vendor'] = $vendor;
        }

        parent::createOption($data);
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
     * Search option to update
     *
     * @param array $data Data
     *
     * @return \XLite\Model\Config
     */
    protected function findOptionToUpdate($data)
    {
        $vendor = $data['vendor'] ?: null;

        return $this->findOneBy(
            array(
                'name'     => $data['name'],
                'category' => $data['category'],
                'vendor'   => $vendor,
            )
        );
    }

    /**
     * Define query builder for getAllOptions()
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function defineAllOptionsQuery()
    {
        $qb = parent::defineAllOptionsQuery();
        $this->prepareCndVendor($qb, null);

        return $qb;
    }

    /**
     * Define query builder for getAllOptions()
     *
     * @param \XLite\Model\Profile|integer|null $vendor Vendor
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function defineAllVendorOptionsQuery($vendor)
    {
        $qb = parent::defineAllOptionsQuery();
        $this->prepareCndVendor($qb, $vendor);

        return $qb;
    }

    /**
     * Prepare vendor search condition
     *
     * @param \Doctrine\ORM\QueryBuilder        $queryBuilder Query builder to prepare
     * @param \XLite\Model\Profile|integer|null $value        Value
     *
     * @return void
     */
    protected function prepareCndVendor(\Doctrine\ORM\QueryBuilder $queryBuilder, $value)
    {
        if (null === $value) {
            $queryBuilder->andWhere('c.vendor IS NULL');

        } else {
            $queryBuilder->andWhere('c.vendor = :vendor')
                ->setParameter('vendor', $value);
        }
    }

    /**
     * Define query builder for findByCategory
     *
     * @param string $category Category
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function defineFindByCategory($category)
    {
        $qb = parent::defineFindByCategory($category);
        $this->prepareCndVendor($qb, null);

        return $qb;
    }
}
