<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\Reviews\View\SearchPanel\Review;

/**
 * Reviews search panel widget extension
 * 
 * @Decorator\Depend ("XC\Reviews")
 */
class Main extends \XLite\Module\XC\Reviews\View\SearchPanel\Review\Main implements \XLite\Base\IDecorator
{
    /**
     * Get CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/XC/MultiVendor/modules/XC/Reviews/style.css';

        return $list;
    }

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
                    \XLite\View\FormField\AFormField::PARAM_LABEL => static::t('Product vendor'),
                    \XLite\View\FormField\Input\AInput::PARAM_PLACEHOLDER => static::t('Email or Company name'),
                )
            );
        }

        return $conditions;
    }
}
