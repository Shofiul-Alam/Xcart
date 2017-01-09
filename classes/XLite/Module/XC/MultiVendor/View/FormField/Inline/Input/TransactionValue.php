<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormField\Inline\Input;

/**
 * TransactionValue field widget
 */
class TransactionValue extends \XLite\View\FormField\Inline\Input\Text\Price
{
    /**
     * Get initial field parameters
     *
     * @param array $field Field data
     *
     * @return array
     */
    protected function getFieldParams(array $field)
    {
        $list = parent::getFieldParams($field);

        $list['dashed'] = true;

        return $list;
    }

    /**
     * Save widget value in entity
     *
     * @param array $field Field data
     *
     * @return void
     */
    public function saveValueDebit($field)
    {
        $value = $field['widget']->getValue();

        if ($value) {
            $this->getEntity()->setValue(-$value);
        }
    }

    /**
     * Save widget value in entity
     *
     * @param array $field Field data
     *
     * @return void
     */
    public function saveValueCredit($field)
    {
        $value = $field['widget']->getValue();

        if ($value) {
            $this->getEntity()->setValue($value);
        }
    }
}
