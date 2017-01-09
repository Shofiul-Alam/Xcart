<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormField\Select;

/**
 * Access level selector
 */
class AccessLevel extends \XLite\View\FormField\Select\AccessLevel implements \XLite\Base\IDecorator
{
    /**
     * Return default options
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        $list = parent::getDefaultOptions();

        if (\XLite\Core\Auth::getInstance()->isPermissionAllowed('manage admins')) {
            $list[\XLite\Core\Auth::getInstance()->getVendorAccessLevel()] = static::t('Vendor');
        }

        return $list;
    }

    /**
     * Check field value validity
     *
     * @return boolean
     */
    protected function checkFieldValue()
    {
        return parent::checkFieldValue()
            || (
                \XLite\Core\Auth::getInstance()->isPermissionAllowed('manage admins')
                && $this->getValue() == \XLite\Core\Auth::getInstance()->getVendorAccessLevel()
            );
    }
}