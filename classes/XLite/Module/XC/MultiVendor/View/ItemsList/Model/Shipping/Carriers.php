<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ItemsList\Model\Shipping;

use XLite\Core;
use XLite\Module\XC\MultiVendor;

/**
 * Shipping carriers list
 */
class Carriers extends \XLite\View\ItemsList\Model\Shipping\Carriers implements \XLite\Base\IDecorator
{
    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        $columns = parent::defineColumns();
        if (Core\Auth::getInstance()->isVendor()) {
            unset($columns['taxClass']);
        }

        return $columns;
    }

    /**
     * Return params list to use for search
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getSearchCondition()
    {
        $result = parent::getSearchCondition();
        $result->{\XLite\Model\Repo\Shipping\Method::P_VENDOR} = Core\Auth::getInstance()->isVendor()
            ? Core\Auth::getInstance()->getProfile()
            : null;

        return $result;
    }
}
