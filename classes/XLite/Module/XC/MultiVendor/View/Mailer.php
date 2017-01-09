<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View;

/**
 * Mailer
 */
class Mailer extends \XLite\View\Mailer implements \XLite\Base\IDecorator
{
    /**
     * Returns orders full url in admin area
     *
     * @param \XLite\Model\Order $order Order
     *
     * @return string
     */
    protected function getOrderAdminUrl($order)
    {
        return \XLite\Core\Converter::buildFullURL(
            'order',
            '',
            array('order_number' => $order->getOrderNumber()),
            \XLite::getAdminScript()
        );
    }
}
