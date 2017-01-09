<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\SearchPanel\Order\Admin;

/**
 * Main admin orders list search panel
 */
class Main extends \XLite\View\SearchPanel\Order\Admin\Main implements \XLite\Base\IDecorator
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

        $conditions += array(
            'commissionMode' => array(
                static::CONDITION_CLASS => 'XLite\Module\XC\MultiVendor\View\FormField\Select\CommissionMode',
                \XLite\View\FormField\AFormField::PARAM_LABEL => static::t('Commission'),
            )
        );

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

    /**
     * Return true if search panel can save filters
     *
     * @return boolean
     */
    protected function canSaveFilter()
    {
        return parent::canSaveFilter() && !\XLite\Core\Auth::getInstance()->isVendor();
    }

    /**
     * Return true if filter may be removed
     *
     * @param \XLite\Model\SearchFilter $filter Search filter model object
     *
     * @return boolean
     */
    protected function isFilterRemovable($filter)
    {
        return parent::isFilterRemovable($filter) && !\XLite\Core\Auth::getInstance()->isVendor();
    }
}
