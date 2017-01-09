<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View;

use XLite\Core\Auth;

/**
 * Admin's 'Welcome...' block widget
 */
class AdminWelcome extends \XLite\View\AdminWelcome implements \XLite\Base\IDecorator
{
    /**
     * Check block visibility
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible() && !Auth::getInstance()->isVendor();
    }
}
