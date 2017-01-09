<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Menu\Admin;

/**
 * Abstract admin menu
 */
abstract class AAdmin extends \XLite\View\Menu\Admin\AAdmin implements \XLite\Base\IDecorator
{
    /**
     * Add (vendor's) item permission for menu item
     *
     * @param array  &$item      Menu item to add permission to
     * @param string $permission Permission code
     *
     * @return void
     */
    protected function addItemPermission(&$item, $permission)
    {
        if (empty($item[static::ITEM_PERMISSION])) {
            $item[static::ITEM_PERMISSION] = array($permission);
        } else {
            $item[static::ITEM_PERMISSION] = is_array($item[static::ITEM_PERMISSION])
                ? array_merge($item[static::ITEM_PERMISSION], array($permission))
                : array($item[static::ITEM_PERMISSION], $permission);
        }
    }
}
