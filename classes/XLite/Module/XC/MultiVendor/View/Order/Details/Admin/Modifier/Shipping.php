<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Order\Details\Admin\Modifier;

/**
 * Shipping modifier widget
 */
class Shipping extends \XLite\View\Order\Details\Admin\Modifier\Shipping implements \XLite\Base\IDecorator
{
    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        $order = $this->getOrder();
        $auth = \XLite\Core\Auth::getInstance();

        return parent::isVisible()
            && !($order->isParent() && $auth->isVendor());
    }
}
