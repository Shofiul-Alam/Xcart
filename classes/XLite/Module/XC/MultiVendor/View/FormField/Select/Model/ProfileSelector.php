<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormField\Select\Model;

/**
 * Profile model selector
 */
class ProfileSelector extends \XLite\View\FormField\Select\Model\ProfileSelector implements \XLite\Base\IDecorator
{
    /**
     * Get field template
     *
     * @return string
     */
    protected function getFieldTemplate()
    {
        return \XLite\Core\Auth::getInstance()->isVendor()
            ? 'input.twig'
            : parent::getFieldTemplate();
    }

    /**
     * Reset commented data
     *
     * @return array
     */
    protected function getCommentedData()
    {
        return \XLite\Core\Auth::getInstance()->isVendor()
            ? array()
            : parent::getCommentedData();
    }

    /**
     * Get common field attributes
     *
     * @return array
     */
    protected function getCommonAttributes()
    {
        $list = parent::getCommonAttributes();

        if (\XLite\Core\Auth::getInstance()->isVendor()) {
            // Vendor cannot select profile model
            $list['type'] = $this->getFieldType();
            $list['value'] = $this->getTextValue() ?: (is_integer($this->getValue()) ? '' : $this->getValue());
            $list['name'] = $this->getTextName();
        }

        return $list;
    }
}
