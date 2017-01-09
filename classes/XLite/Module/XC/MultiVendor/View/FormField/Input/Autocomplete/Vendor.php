<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormField\Input\Autocomplete;

/**
 * Autocomplete vendor field
 */
class Vendor extends \XLite\View\FormField\Input\Text\Base\Autocomplete
{
    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'modules/XC/MultiVendor/form_field/input/autocomplete/vendor.js';

        return $list;
    }

    /**
     * Get dictionary name
     *
     * @return string
     */
    protected function getDictionary()
    {
        return 'vendors';
    }

    /**
     * getDefaultValue
     *
     * @return string
     */
    protected function getDefaultValue()
    {
        return '';
    }
}
