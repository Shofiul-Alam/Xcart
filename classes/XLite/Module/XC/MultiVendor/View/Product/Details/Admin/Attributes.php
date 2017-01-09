<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Product\Details\Admin;

/**
 * Product attributes widget class
 */
class Attributes extends \XLite\View\Product\Details\Admin\Attributes implements \XLite\Base\IDecorator
{
    /**
     * Get list of parameters for attribute name widget
     *
     * @param \XLite\Model\Attribute $attribute Attribute
     *
     * @return array
     */
    protected function getAttributeNameWidgetParams($attribute)
    {
        $result = parent::getAttributeNameWidgetParams($attribute);

        if (\XLite\Core\Auth::getInstance()->isVendor()
            && !\XLite\Core\Auth::getInstance()->checkVendorAccess($attribute->getVendor())
        ) {
            $result = array_merge(
                $result,
                array(
                    'viewOnly' => true,
                )
            );
        }

        return $result;
    }

    /**
     * Return true if attributes van be removed
     *
     * @return boolean
     */
    protected function isRemovable()
    {
        return parent::isRemovable() && $this->isValidVendor();
    }

    /**
     * Return true if new attributes can be added
     *
     * @return boolean
     */
    protected function canAddAttributes()
    {
        return parent::canAddAttributes() && $this->isValidVendor();
    }

    /**
     * Return true if current user is valid vendor
     *
     * @return boolean
     */
    protected function isValidVendor()
    {
        $result = true;

        if (\XLite\Core\Auth::getInstance()->isVendor()) {
            $vendor = null;

            if ($this->getProductClass()) {
                $vendor = $this->getProductClass()->getVendor();

            } elseif ($this->getAttributeGroup()) {
                $vendor = $this->getAttributeGroup()->getVendor();

            } elseif ($this->getPersonalOnly() && $this->getProduct()) {
                $vendor = $this->getProduct()->getVendor();
            }

            $result = $vendor && \XLite\Core\Auth::getInstance()->checkVendorAccess($vendor);
        }

        return $result;
    }
}
