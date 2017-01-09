<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\ProductVariants\Model\Repo;

/**
 * ProductVariant model repository extension
 * 
 * @Decorator\Depend ("XC\ProductVariants")
 */
class ProductVariant extends \XLite\Module\XC\ProductVariants\Model\Repo\ProductVariant implements \XLite\Base\IDecorator
{
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
        if ('vendor' == $name) {

            $auth = \XLite\Core\Auth::getInstance();

            if ($auth->isVendor()) {
                $value = $auth->getVendor()->getLogin();
            }

            $alias = $qb->getMainAlias();
            $qb->linkInner($alias . '.product', 'product');

            if ($value) {
                $qb->linkLeft('product.vendor', 'vendor')
                    ->andWhere('vendor.login = :vendorLogin')
                    ->setParameter('vendorLogin', $value);

            } else {
                $qb->andWhere('product.vendor IS NULL');
            }

        } else {
            parent::addImportCondition($qb, $name, $value);
        }
    }
}
