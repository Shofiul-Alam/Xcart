<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ItemsList\Model;

use XLite\Core\Auth;
use XLite\Model\AEntity;

/**
 * Attribute groups items list
 */
class AttributeGroup extends \XLite\View\ItemsList\Model\AttributeGroup implements \XLite\Base\IDecorator
{
    /**
     * Create entity
     *
     * @return \XLite\Model\AEntity
     */
    protected function createEntity()
    {
        $entity = parent::createEntity();

        $auth = Auth::getInstance();

        if ($auth->getVendor()) {
            $entity->setVendor($auth->getVendor());
        }

        return $entity;
    }

    /**
     * Pre-validate entity
     *
     * @param \XLite\Model\AEntity $entity Entity
     *
     * @return boolean
     */
    protected function prevalidateEntity(AEntity $entity)
    {
        $result = parent::prevalidateEntity($entity);

        if ($result) {
            $auth = Auth::getInstance();

            if ($auth->getVendor() && !$entity->isOfCurrentVendor()) {
                $result = false;
            }
        }

        return $result;
    }

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        $columns = parent::defineColumns();

        if (!Auth::getInstance()->isVendor()) {
            $columns['vendor'] = array(
                static::COLUMN_TEMPLATE => 'modules/XC/MultiVendor/item_lists/parts/vendor_link.twig',
                static::COLUMN_ORDERBY  => 150,
            );
        }

        return $columns;
    }

    /**
     * Return vendor profile link
     *
     * @param mixed $entity Model
     *
     * @return string
     */
    protected function getVendorProfileURL($entity)
    {
        $entityHasVendor = $entity && $entity->getId() && $entity->getVendor();

        return $entityHasVendor
            ? $this->buildURL('profile', '', array('profile_id' => $entity->getVendor()->getProfileId()))
            : '';
    }

    /**
     * Return vendor profile link caption
     *
     * @param mixed $entity Model
     *
     * @return string
     */
    protected function getVendorProfileLinkCaption($entity)
    {
        $entityHasVendor = $entity && $entity->getId() && $entity->getVendor();

        return $entityHasVendor
            ? $entity->getVendor()->getName() . ' (' . $entity->getVendor()->getLogin() . ')'
            : '';
    }
}
