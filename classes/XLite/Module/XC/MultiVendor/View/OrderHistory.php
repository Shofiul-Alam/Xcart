<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View;

/**
 * Order history widget
 */
class OrderHistory extends \XLite\View\OrderHistory implements \XLite\Base\IDecorator
{
    /**
     * Define blocks for the events of order
     *
     * @return array
     */
    protected function defineOrderHistoryEventsBlock()
    {
        $result = parent::defineOrderHistoryEventsBlock();

        if (\XLite\Core\Auth::getInstance()->isVendor()) {
            $profileId = \XLite\Core\Auth::getInstance()->getProfile()->getProfileId();
            foreach ($result as $k => $events) {
                $result[$k] = array_filter($events, function ($item) use ($profileId) {
                    return $item->getOrder()->getVendor()
                        && $item->getOrder()->getVendor()->getProfileId() === $profileId;
                });
            }
        }

        return array_filter($result);
    }

    /**
     * Return true if event has more then one order relation
     *
     * @param \XLite\Model\OrderHistoryEvents $event Event object
     *
     * @return boolean
     */
    protected function hasRelations(\XLite\Model\OrderHistoryEvents $event)
    {
        $order = $event->getOrder();

        return $order
            && !(bool) $order->getOrderNumber()
            && $order->getChildren()
            && 1 < $order->getChildren()->count();
    }

    /**
     * Return true if event has more then one order relation
     *
     * @param \XLite\Model\OrderHistoryEvents $event Event object
     *
     * @return \XLite\Model\Order[]
     */
    protected function getRelations(\XLite\Model\OrderHistoryEvents $event)
    {
        return $event->getOrder()->getChildren();
    }

    /**
     * Returns order url
     *
     * @param \XLite\Model\Order $order Order
     *
     * @return string
     */
    protected function getRelationURL(\XLite\Model\Order $order)
    {
        return $this->buildURL('order', '', array('order_number' => $order->getOrderNumber()));
    }

    /**
     * Returns true if given order is current order
     *
     * @param \XLite\Model\Order $order Order
     *
     * @return boolean
     */
    protected function isCurrentOrder(\XLite\Model\Order $order)
    {
        return $this->getOrder()->getOrderId() === $order->getOrderId();
    }
}
