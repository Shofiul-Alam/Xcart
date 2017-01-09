<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\UpdateInventory\View\Menu\Admin;

/**
 * Left menu
 *
 * @Decorator\Depend ("XC\UpdateInventory")
 */
class LeftMenu extends \XLite\View\Menu\Admin\LeftMenu implements \XLite\Base\IDecorator
{
    /**
     * Define menu items
     *
     * @return array
     */
    protected function defineItems()
    {
        $items = parent::defineItems();

        if (\XLite\Core\Auth::getInstance()->isVendor()) {
            $this->addItemPermission(
                $items['catalog'][static::ITEM_CHILDREN][\XLite\Module\XC\UpdateInventory\Main::TARGET_UPDATE_INVENTORY],
                '[vendor] manage catalog'
            );
        }

        return $items;
    }
}
