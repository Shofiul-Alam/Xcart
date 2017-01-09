<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\Repo;

/**
 * The Vendor model repository
 */
class Vendor extends \XLite\Model\Repo\Base\I18n
{
    /**
     * Link vendor translation table
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder
     * @param string                     $alias        Vendor table alias
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function linkTranslation($queryBuilder, $alias)
    {
        return $this->addTranslationJoins($queryBuilder, $alias, $alias . 'Translation', $this->getTranslationCode());
    }
}
