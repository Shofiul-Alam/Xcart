<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormField\Select;

/**
 * Multi vendor mode selector
 */
class MultiVendorMode extends \XLite\View\FormField\Select\Regular
{
    /**
     * Get default options list
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        $options = array();
        $options['W'] = static::t('Warehouse');
        $options['S'] = static::t('Vendors as separate shops');

        return $options;
    }
}
