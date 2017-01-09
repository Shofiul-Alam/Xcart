<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\Repo;

use Doctrine\ORM\QueryBuilder;

/**
 * Order tracking number repository
 * todo: revise in MultiVendor+MultiShipping task
 */
class OrderTrackingNumber extends \XLite\Model\Repo\OrderTrackingNumber implements \XLite\Base\IDecorator
{
    /**
     * Search parameter names
     */
    const P_VENDOR_ID = 'vendorId';

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param integer                    $vendorId     Condition data
     *
     * @return void
     */
    protected function prepareCndVendorId(QueryBuilder $queryBuilder, $vendorId)
    {
        if (!empty($vendorId)) {
            $alias = $this->getDefaultAlias();

            $queryBuilder->andWhere("$alias.vendor = :vendorId")
                ->setParameter('vendorId', $vendorId);
        }
    }
}
