<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\VolumeDiscounts\View\SearchPanel;

/**
 * Main admin product search panel
 *
 * @Decorator\Depend ("CDev\VolumeDiscounts")
 */
class VolumeDiscount extends \XLite\View\SearchPanel\ASearchPanel
{
    /**
     * Get form class
     *
     * @return string
     */
    protected function getFormClass()
    {
        return 'XLite\Module\XC\MultiVendor\Module\CDev\VolumeDiscounts\View\Form\Search\VolumeDiscount';
    }

    /**
     * Define the items list CSS class with which the search panel must be linked
     *
     * @return string
     */
    protected function getLinkedItemsList()
    {
        return parent::getLinkedItemsList() . '.widget.items-list.volume-discounts';
    }

    /**
     * Define conditions
     *
     * @return array
     */
    protected function defineConditions()
    {
        return parent::defineConditions() + array(
            'vendor' => array(
                static::CONDITION_CLASS => 'XLite\Module\XC\MultiVendor\View\FormField\Input\Autocomplete\Vendor',
                \XLite\View\FormField\AFormField::PARAM_LABEL => static::t('Vendor'),
                \XLite\View\FormField\Input\AInput::PARAM_PLACEHOLDER => static::t('Email or Company name'),
            )
        );
    }
}
