<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormField\Inline\Input;

/**
 * Product class name field widget
 */
class ProductClass extends \XLite\View\FormField\Inline\Input\Text\ProductClass implements \XLite\Base\IDecorator
{
    /**
     * Check - field is editable or not
     *
     * @return boolean
     */
    protected function isEditable()
    {
        return parent::isEditable()
            && \XLite\Core\Auth::getInstance()->checkVendorAccess($this->getEntity()->getVendor());
    }
}
