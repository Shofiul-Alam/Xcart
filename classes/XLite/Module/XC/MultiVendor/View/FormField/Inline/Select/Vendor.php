<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormField\Inline\Select;

/**
 * Vendor profiles select
 */
class Vendor extends \XLite\View\FormField\Inline\Base\Single
{
    /**
     * Define form field
     *
     * @return string
     */
    protected function defineFieldClass()
    {
        return 'XLite\Module\XC\MultiVendor\View\FormField\Select\Vendor';
    }

    /**
     * Get edit only flag
     *
     * @return boolean
     */
    protected function getEditOnly()
    {
        return !$this->getEntity()->isPersistent();
    }

    /**
     * Get view value
     *
     * @param array $field Field
     *
     * @return mixed
     */
    protected function getViewValue(array $field)
    {
        $product = $this->getEntity();

        if ($product->getVendor()) {
            $profile = $product->getVendor();

            if ($profile) {
                return $profile->getVendorCompanyName() . ' (' . $profile->getLogin() . ')';
            }
        }

        return static::t('Administrator');
    }
}
