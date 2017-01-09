<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ItemsList\Model;

use XLite\Core\Auth;

/**
 * Product classes items list
 */
class ProductClass extends \XLite\View\ItemsList\Model\ProductClass implements \XLite\Base\IDecorator
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
    protected function prevalidateEntity(\XLite\Model\AEntity $entity)
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
            ? $entity->getVendor()->getVendorCompanyName() . ' (' . $entity->getVendor()->getLogin() . ')'
            : '';
    }

    /**
     * Return true if aentity could be removed
     *
     * @param \XLite\Model\AEntity $entity Entity
     *
     * @return boolean
     */
    protected function isAllowEntityRemove(\XLite\Model\AEntity $entity)
    {
        return parent::isAllowEntityRemove($entity) && $this->isValidVendor($entity);
    }

    /**
     * Return true id entity's vendor is the same as currently logged in user
     *
     * @param \XLite\Model\AEntity $entity Entity
     *
     * @return boolean
     */
    protected function isValidVendor(\XLite\Model\AEntity $entity)
    {
        return Auth::getInstance()->checkVendorAccess($entity->getVendor());
    }

    /**
     * Disable sorting entities
     *
     * @return integer
     */
    protected function getSortableType()
    {
        return Auth::getInstance()->isVendor() ? static::SORT_TYPE_NONE : parent::getSortableType();
    }

    /**
     * Get label for edit link
     *
     * @param \XLite\Model\AEntity $entity Entity
     *
     * @return string
     */
    protected function getEditLinkLabel($entity)
    {
        return $this->isValidVendor($entity) ? parent::getEditLinkLabel($entity) : static::t('View attributes');
    }
}
