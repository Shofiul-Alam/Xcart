<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormField\Select;

/**
 * Default vendor role selector
 */
class DefaultVendorRole extends \XLite\View\FormField\Select\Regular
{
    /**
     * Get default options list
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        $options = array();

        $roles = \XLite\Core\Database::getRepo('XLite\Model\Role')->findAll();

        foreach ($roles as $role) {
            if ($role->isVendor()) {
                $options[$role->getId()] = $role->getPublicName();
            }
        }

        return $options;
    }
}
