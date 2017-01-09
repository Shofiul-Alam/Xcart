<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View;

use XLite\Core\Auth;

/**
 * Tabber link widget
 *
 * @Decorator\Depend ("CDev\GoogleAnalytics")
 */
class TabberLink extends \XLite\Module\CDev\GoogleAnalytics\View\TabberLink implements \XLite\Base\IDecorator
{
    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible() && !Auth::getInstance()->isVendor();
    }
}
