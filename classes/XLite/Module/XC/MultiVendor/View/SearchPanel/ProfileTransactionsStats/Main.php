<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\SearchPanel\ProfileTransactionsStats;

use XLite\Module\XC\MultiVendor;

/**
 * ProfileTransactionsStats search panel
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
        return 'XLite\Module\XC\MultiVendor\View\Form\ItemsList\ProfileTransactionsStats\Search';
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
            MultiVendor\View\ItemsList\Model\ProfileTransactionsStats::PARAM_PROFILE => array(
                static::CONDITION_CLASS => '\XLite\View\FormField\Input\Text',
                \XLite\View\FormField\AFormField::PARAM_FIELD_ONLY  => true,
                \XLite\View\FormField\Input\Text::PARAM_PLACEHOLDER => static::t('Enter keyword'),
                \XLite\View\FormField\Select\Profile\AProfile::PARAM_SHOW_ANY_OPTION => true
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

        $actions['submit'][\XLite\View\Button\AButton::PARAM_LABEL] = static::t('Search');

        $actions['clear_search'] = array(
            'template' => 'modules/XC/MultiVendor/profile_transactions_stats/search_panel/clear_search.twig'
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
        return parent::getLinkedItemsList() . '.widget.items-list.profile-transaction-stats';
    }

    /**
     * Get itemsList
     *
     * @return \XLite\View\ItemsList\Model\Table
     */
    protected function getItemsList()
    {
        return $this->getParam(static::PARAM_ITEMS_LIST) ?: new \XLite\Module\XC\MultiVendor\View\ItemsList\Model\ProfileTransactionsStats;
    }
}
