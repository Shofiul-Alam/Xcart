<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Admin;

use XLite\Core\Auth;

/**
 * Review modify controller
 *
 * @Decorator\Depend("XC\Reviews")
 */
abstract class Review extends \XLite\Module\XC\Reviews\Controller\Admin\Review implements \XLite\Base\IDecorator
{
    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        return parent::checkACL() || Auth::getInstance()->isVendor();
    }

    /**
     * Check if current page is accessible
     *
     * @return boolean
     */
    public function checkAccess()
    {
        $availableForUser = true;

        if (Auth::getInstance()->isVendor() && $this->getProduct()) {
            $availableForUser = $this->getProduct()->isOfCurrentVendor();
        }

        return parent::checkAccess() && $availableForUser;
    }
}
