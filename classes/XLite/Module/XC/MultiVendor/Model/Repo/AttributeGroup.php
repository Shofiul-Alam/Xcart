<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\Repo;

use XLite\Core\Auth;

/**
 * Attributes repository
 */
class AttributeGroup extends \XLite\Model\Repo\AttributeGroup implements \XLite\Base\IDecorator
{
    /**
     * Insert entity
     *
     * @param \XLite\Model\AEntity|array $entity Entity to insert OPTIONAL
     * @param boolean                    $flush  Flag OPTIONAL OPTIONAL
     *
     * @return \XLite\Model\AEntity
     */
    public function insert($entity = null, $flush = self::FLUSH_BY_DEFAULT)
    {
        $auth = Auth::getInstance();

        $productClass = null;

        if ($entity) {
            if (is_array($entity) && isset($entity['productClass'])) {
                $productClass = $entity['productClass'];

            } elseif (!is_array($entity)) {
                $productClass = $entity->getProductClass();
            }
        }
        if ($productClass && $productClass->getVendor()) {
            $entity->setVendor(
                $productClass->getVendor()
            );
        }

        return parent::insert($entity, $flush);
    }
}
