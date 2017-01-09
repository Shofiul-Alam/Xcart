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
class Markup extends \XLite\Model\Repo\Shipping\Markup implements \XLite\Base\IDecorator
{
    /**
     * Define query builder object for findMarkupsByProcessor()
     *
     * @param string                               $processor Processor class name
     * @param \XLite\Logic\Order\Modifier\Shipping $modifier  Shipping order modifier
     * @param integer                              $zoneId    Zone Id
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function defineFindMarkupsByProcessorQuery(
        $processor,
        \XLite\Logic\Order\Modifier\Shipping $modifier,
        $zoneId
    ) {
        $qb = parent::defineFindMarkupsByProcessorQuery($processor, $modifier, $zoneId);
        $vendor = $modifier->getOrder()->getVendor();

        $qb->linkInner('m.shipping_method');

        if ($vendor) {
            $qb->andWhere('shipping_method.vendor = :vendor')
                ->setParameter('vendor', $vendor);

        } else {
            $qb->andWhere('shipping_method.vendor IS NULL');
        }

        return $qb;
    }
}
