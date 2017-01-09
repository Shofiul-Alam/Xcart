<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Customer;

/**
 * Customer log in page controller
 */
class Login extends \XLite\Controller\Customer\Login implements \XLite\Base\IDecorator
{
    /**
     * Return false if $profile is non-admin or vendor profile
     *
     * @param \XLite\Model\Profile $profile User profile
     *
     * @return boolean
     */
    protected function isLoginDisabled($profile)
    {
        return parent::isLoginDisabled($profile) && !$profile->isVendor();
    }
}
