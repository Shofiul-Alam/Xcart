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
class Promotions extends \XLite\Controller\Admin\Promotions implements \XLite\Base\IDecorator
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
     * Get pages static
     *
     * @return array
     */
    public static function getPagesStatic()
    {
        $list = parent::getPagesStatic();
        if (isset($list[static::PAGE_COUPONS], $list[static::PAGE_COUPONS]['permission'])
            && Core\Auth::getInstance()->isVendor()
        ) {
            $list[static::PAGE_COUPONS]['permission'] = '[vendor] manage catalog';
        }

        return $list;
    }
}
