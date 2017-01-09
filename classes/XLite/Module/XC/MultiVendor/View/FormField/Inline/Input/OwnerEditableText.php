<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormField\Inline\Input;

/**
 * Text
 */
class OwnerEditableText extends \XLite\View\FormField\Inline\Input\Text
{
    /**
     * Check - field is editable or not
     *
     * @return boolean
     */
    protected function isEditable()
    {
        return $this->getEntity()->isOfCurrentVendor();
    }
}
