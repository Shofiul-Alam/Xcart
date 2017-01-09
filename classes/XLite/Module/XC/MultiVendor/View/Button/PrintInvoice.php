<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Button;

use XLite\Core\Auth;

/**
 * 'Print invoice' button widget
 */
class PrintInvoice extends \XLite\View\Button\PrintInvoice implements \XLite\Base\IDecorator
{
    /**
     * Get default label
     *
     * @return string
     */
    protected function getDefaultLabel()
    {
        $order = $this->getOrder();

        return $order && Auth::getInstance()->isVendor() && (!$order->isOfCurrentVendor() || $order->isSingle())
            ? 'Print order'
            : parent::getDefaultLabel();
    }

    /**
     * Return URL params to use with onclick event
     *
     * @return array
     */
    protected function getURLParams()
    {
        $result = parent::getURLParams();

        if ($this->getOrder()
            && $this->getOrder()->isParent()
            && !\XLite\Module\XC\MultiVendor\Main::isWarehouseMode()
        ) {
            unset($result['url_params']['order_number']);

            $ids = array_map(
                function($child) {
                    return $child->getOrderId();
                },
                $this->getOrder()->getChildren()->toArray()
            );

            $result['url_params']['order_id'] = $this->getOrder()->getOrderId();
            $result['url_params']['order_ids'] = implode(',', $ids);
        }

        return $result;
    }
}
