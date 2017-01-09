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
class Attribute extends \XLite\Model\Repo\Attribute implements \XLite\Base\IDecorator
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

        if (\XLite::isAdminZone()
            && $auth->isVendor()
        ) {
            $vendor = $this->getEntityManager()->merge($auth->getVendor());
            $entity->setVendor($vendor);
        }

        return parent::insert($entity, $flush);
    }
}
