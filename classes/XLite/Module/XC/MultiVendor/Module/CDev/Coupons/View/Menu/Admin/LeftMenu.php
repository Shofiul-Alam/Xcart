<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\Coupons\View\Menu\Admin;

use XLite\Core\Auth;

/**
 * Left menu
 *
 * @Decorator\Depend ("CDev\Coupons")
 */
class LeftMenu extends \XLite\View\Menu\Admin\LeftMenu implements \XLite\Base\IDecorator
{
    /**
     * Define quick links
     *
     * @return array
     */
    protected function defineQuickLinks()
    {
        $items = parent::defineQuickLinks();
        if (Auth::getInstance()->isVendor()) {
            $addNewChildren = &$items['add_new'][static::ITEM_CHILDREN];
            $this->addItemPermission($addNewChildren['add_coupon'], '[vendor] manage catalog');
        }

        return $items;
    }
}
