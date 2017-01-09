<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Button;

/**
 * 'LoginAsAdmin' button widget
 */
abstract class LoginAsAdmin extends \XLite\View\Button\LoginAsAdmin implements \XLite\Base\IDecorator
{
    /**
     * Get default label
     * todo: move translation here
     *
     * @return string
     */
    protected function getDefaultLabel()
    {
        return $this->getProfile() && $this->getProfile()->isVendor()
             ? 'Log in as this vendor'
             : parent::getDefaultLabel();
    }
}
