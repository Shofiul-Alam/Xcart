<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Admin;

/**
 * SearchRouter controller
 */
abstract class SearchRouter extends \XLite\Controller\Admin\SearchRouter implements \XLite\Base\IDecorator
{
    /**
     * Extend search code permissions with vendor's permissions
     *
     * @return array
     */
    protected static function getSearchCodePermissions()
    {
        $list = parent::getSearchCodePermissions();
        $list['product'][] = '[vendor] manage catalog';
        $list['order'][]   = '[vendor] manage orders';
        $list['profile'][] = '[vendor] manage users';

        return $list;
    }
}
