<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\SearchPanel\Product\Admin;

/**
 * Main admin product search panel
 */
class Main extends \XLite\View\SearchPanel\Product\Admin\Main implements \XLite\Base\IDecorator
{
    /**
     * Define hidden conditions
     *
     * @return array
     */
    protected function defineHiddenConditions()
    {
        $conditions = parent::defineHiddenConditions();

        if (!\XLite\Core\Auth::getInstance()->isVendor()) {
            $conditions += array(
                'vendor' => array(
                    static::CONDITION_CLASS => 'XLite\Module\XC\MultiVendor\View\FormField\Input\Autocomplete\Vendor',
                    \XLite\View\FormField\AFormField::PARAM_LABEL => static::t('Vendor'),
                    \XLite\View\FormField\Input\AInput::PARAM_PLACEHOLDER => static::t('Email or Company name'),
                )
            );
        }

        return $conditions;
    }

    /**
     * Get wrapper form params
     *
     * @return array
     */
    protected function getFormParams()
    {
        return array_merge(
            parent::getFormParams(),
            array(
                'vendorId' => $this->getCondition('vendorId')
            )
        );
    }
}
