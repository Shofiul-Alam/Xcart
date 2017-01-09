<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormField\Select\OrderStatus;

use XLite\Core\Auth;

/**
 * Abstract order status selector
 */
abstract class AOrderStatus extends \XLite\View\FormField\Select\OrderStatus\AOrderStatus implements \XLite\Base\IDecorator
{
    /**
     * prepareAttributes
     *
     * @param array $attrs Field attributes to prepare
     *
     * @return array
     */
    protected function prepareAttributes(array $attrs)
    {
        $order = $this->getOrder();

        if ($order
            && Auth::getInstance()->isVendor()
            && (!$order->isOfCurrentVendor() || $order->isSingle())
        ) {
            $attrs += array('disabled' => 'disabled');
        }

        return parent::prepareAttributes($attrs);
    }
}
