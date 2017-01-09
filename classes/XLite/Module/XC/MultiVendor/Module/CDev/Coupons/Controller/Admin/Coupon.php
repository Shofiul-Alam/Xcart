<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\Coupons\Controller\Admin;

use XLite\Core;
use XLite\Model;

/**
 * Coupon
 *
 * @Decorator\Depend ("CDev\Coupons")
 */
class Coupon extends \XLite\Module\CDev\Coupons\Controller\Admin\Coupon implements \XLite\Base\IDecorator
{
    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        return parent::checkACL() || Core\Auth::getInstance()->isPermissionAllowed('[vendor] manage catalog');
    }

    /**
     * Check if current page is accessible
     * todo: add method like isRootAccessAllowed in \XLite\Core\Auth
     *
     * @return boolean
     */
    public function checkAccess()
    {
        return parent::checkAccess()
            && ($this->getCoupon()->isOfCurrentVendor()
                || Core\Auth::getInstance()->isPermissionAllowed(Model\Role\Permission::ROOT_ACCESS)
            );
    }
}
