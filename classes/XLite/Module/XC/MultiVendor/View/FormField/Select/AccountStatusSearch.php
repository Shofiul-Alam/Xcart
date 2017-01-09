<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormField\Select;

use XLite\Module\XC\MultiVendor;

/**
 * Profile status selector for search panel
 */
class AccountStatusSearch extends \XLite\View\FormField\Select\AccountStatusSearch implements \XLite\Base\IDecorator
{
    /**
     * Get default options list for profile status selector
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        $options = parent::getDefaultOptions();

        if (!isset($options[MultiVendor\Model\Profile::STATUS_UNAPPROVED_VENDOR])) {
            $options[MultiVendor\Model\Profile::STATUS_UNAPPROVED_VENDOR] = static::t('Unapproved vendor');
        }

        return $options;
    }
}
