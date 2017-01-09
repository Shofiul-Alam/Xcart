<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\SearchPanel\ProfileTransactions;

use XLite\Module\XC\MultiVendor;

/**
 * Countries search panel
 */
class Main extends \XLite\View\SearchPanel\ASearchPanel
{
    /**
     * Get form class
     *
     * @return string
     */
    protected function getFormClass()
    {
        return 'XLite\Module\XC\MultiVendor\View\Form\ItemsList\ProfileTransactions\Search';
    }

    /**
     * Define conditions
     *
     * @return array
     */
    protected function defineConditions()
    {
        $conditions = parent::defineConditions();

        $conditions += array(
            MultiVendor\View\ItemsList\Model\ProfileTransactions::PARAM_DATE_RANGE => array(
                static::CONDITION_CLASS => '\XLite\View\FormField\Input\Text\DateRange',
                \XLite\View\FormField\AFormField::PARAM_FIELD_ONLY  => true,
            ),
        );

        if (!\XLite\Core\Auth::getInstance()->isVendor()) {
            $conditions += array(
                MultiVendor\View\ItemsList\Model\ProfileTransactions::PARAM_PROFILE    => array(
                    static::CONDITION_CLASS                             => 'XLite\Module\XC\MultiVendor\View\FormField\Select\Profile\Vendor',
                    \XLite\View\FormField\AFormField::PARAM_FIELD_ONLY  => true,
                    \XLite\View\FormField\Select\Profile\AProfile::PARAM_SHOW_ANY_OPTION => true
                ),
            );
        }

        $conditions += array(
            MultiVendor\View\ItemsList\Model\ProfileTransactions::PARAM_DESCRIPTION_SUBSTRING => array(
                static::CONDITION_CLASS => '\XLite\View\FormField\Input\Text',
                \XLite\View\FormField\AFormField::PARAM_FIELD_ONLY  => true,
                \XLite\View\FormField\Input\Text::PARAM_PLACEHOLDER => static::t('Enter description'),
            ),
        );

        return $conditions;
    }

    /**
     * Define actions
     *
     * @return array
     */
    protected function defineActions()
    {
        $actions = parent::defineActions();

        $actions['submit'][\XLite\View\Button\AButton::PARAM_LABEL] = static::t('Find transactions');

        $actions['clear_search'] = array(
            'template' => 'modules/XC/MultiVendor/profile_transactions/search_panel/clear_search.twig'
        );

        return $actions;
    }

    /**
     * Define the items list CSS class with which the search panel must be linked
     *
     * @return string
     */
    protected function getLinkedItemsList()
    {
        return parent::getLinkedItemsList() . '.widget.items-list.profile-transaction';
    }

    /**
     * Get itemsList
     *
     * @return \XLite\View\ItemsList\Model\Table
     */
    protected function getItemsList()
    {
        return $this->getParam(static::PARAM_ITEMS_LIST) ?: new \XLite\Module\XC\MultiVendor\View\ItemsList\Model\ProfileTransactions;
    }
}
