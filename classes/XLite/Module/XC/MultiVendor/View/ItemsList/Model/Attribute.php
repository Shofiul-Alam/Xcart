<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ItemsList\Model;

use XLite\Core\Auth;

/**
 * Attributes items list
 */
class Attribute extends \XLite\View\ItemsList\Model\Attribute implements \XLite\Base\IDecorator
{
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
                static::COLUMN_TEMPLATE      => 'modules/XC/MultiVendor/item_lists/parts/vendor_link.twig',
                static::COLUMN_HEAD_TEMPLATE => 'modules/XC/MultiVendor/item_lists/parts/attribute_group_vendor_head.twig',
                static::COLUMN_ORDERBY       => 150,
            );

        } elseif ($this->isStatic()) {
            unset($columns['name'][static::COLUMN_CLASS]);
            $columns['name'][static::COLUMN_TEMPLATE] = 'modules/XC/MultiVendor/item_lists/parts/attribute_link.twig';
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
        return $entity && $entity->getId() && $this->getAttributeVendor($entity)
            ? $this->buildURL('profile', '', array('profile_id' => $this->getAttributeVendor($entity)->getProfileId()))
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
        return $entity && $entity->getId() && $this->getAttributeVendor($entity)
            ? $this->getAttributeVendor($entity)->getName() . ' (' . $this->getAttributeVendor($entity)->getLogin() . ')'
            : '';
    }

    /**
     * Get attribute vendor. Either directly (for global attributes) or
     * infer from connected product class entity
     *
     * @param \XLite\Model\Attribute $attribute Attribute model
     *
     * @return mixed
     */
    protected function getAttributeVendor($attribute)
    {
        $vendor = $attribute->getVendor();

        if ($attribute->getProductClass() && $attribute->getProductClass()->getVendor()) {
            $vendor = $attribute->getProductClass()->getVendor();
        }

        return $vendor;
    }

    /**
     * Return vendor profile link
     *
     * @return string
     */
    protected function getAttributeGroupVendorProfileURL()
    {
        $aGroup = $this->getAttributeGroup();
        $aGroupHasVendor = $aGroup && $aGroup->getVendor();

        return $aGroupHasVendor
            ? $this->buildURL('profile', '', array('profile_id' => $aGroup->getVendor()->getProfileId()))
            : '';
    }

    /**
     * Return vendor profile link caption
     *
     * @return string
     */
    protected function getAttributeGroupVendorProfileLinkCaption()
    {
        $aGroup = $this->getAttributeGroup();
        $aGroupHasVendor = $aGroup->getVendor();

        return $aGroupHasVendor
            ? $aGroup->getVendor()->getName() . ' (' . $aGroup->getVendor()->getLogin() . ')'
            : '';
    }

    /**
     * Return true if current product class was not created by current vendor
     *
     * @return boolean
     */
    protected function isStatic()
    {
        $result = parent::isStatic();

        if (!$result && Auth::getInstance()->isVendor()) {
            $productClass = $this->getProductClass();
            $result = !$productClass || !Auth::getInstance()->checkVendorAccess($productClass->getVendor());
        }

        return $result;
    }
}
