<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View;

use XLite\Core\Auth;

/**
 * Tabber
 */
class Tabber extends \XLite\View\Tabber implements \XLite\Base\IDecorator
{
    /**
     * Checks whether the tabs navigation is visible, or not
     *
     * @return boolean
     */
    protected function isTabsNavigationVisible()
    {
        return ('order' === $this->getTarget() && Auth::getInstance()->isVendor())
            || parent::isTabsNavigationVisible();
    }
}
