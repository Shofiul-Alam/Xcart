<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\StickyPanel\Order;

/**
 * Orders list form sticky panel
 */
class Admin extends \XLite\View\StickyPanel\Order\Admin\AAdmin implements \XLite\Base\IDecorator
{
    /**
     * Define buttons widgets
     *
     * @return array
     */
    protected function defineButtons()
    {
        $list = parent::defineButtons();

        if (\XLite\Core\Auth::getInstance()->isVendor() && isset($list['export'])) {
            unset($list['export']);
        }

        return $list;
    }
}
