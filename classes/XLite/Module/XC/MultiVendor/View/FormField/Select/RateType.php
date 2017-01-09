<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormField\Select;

/**
 * Rate type selector
 */
class RateType extends \XLite\View\FormField\Select\Regular
{
    const PARAM_GLOBAL_RATE     = 0;
    const PARAM_SPECIAL_RATE    = 1;

    /**
     * Get default options list
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        $options = array();

        $options[static::PARAM_GLOBAL_RATE]     = static::t('Global rate');
        $options[static::PARAM_SPECIAL_RATE]    = static::t('Special rate');

        return $options;
    }
}
