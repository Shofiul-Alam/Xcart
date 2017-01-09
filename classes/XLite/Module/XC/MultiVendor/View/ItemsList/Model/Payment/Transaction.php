<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ItemsList\Model\Payment;

use XLite\Module\XC\MultiVendor;

/**
 * Payment transactions items list
 */
class Transaction extends \XLite\View\ItemsList\Model\Payment\Transaction implements \XLite\Base\IDecorator
{
    const PARAM_LINKED_ORDER = 'linkedOrder';

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_LINKED_ORDER
                => new \XLite\Model\WidgetParam\TypeObject('Linked order', null, false, 'XLite\Model\Order'),
        );
    }

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        $list = parent::defineColumns();
        $list['order'][static::COLUMN_TEMPLATE]
            = 'modules/XC/MultiVendor/item_lists/parts/transaction.cell.orders.twig';

        return $list;
    }

    /**
     * Return order entity for given transaction
     *
     * @param \XLite\Model\Payment\Transaction $entity Transaction entity
     *
     * @return \XLite\Model\Order
     */
    protected function getOrder($entity)
    {
        return $this->getParam(static::PARAM_LINKED_ORDER) ?: $entity->getOrder();
    }

    /**
     * Return orders for 'order' column
     *
     * @param \XLite\Model\Payment\Transaction $entity Entity
     *
     * @return \XLite\Model\Order[]
     */
    protected function getOrders($entity)
    {
        /** @var \XLite\Model\Order $order */
        $order = $entity->getOrder();

        return $this->isDisplayChildren($order)
            ? $order->getChildren()->toArray()
            : array($order);
    }

    /**
     * Return true if links to order's children should be displayed in the 'Order' column
     *
     * @param \XLite\Model\Order $order Order object
     *
     * @return boolean
     */
    protected function isDisplayChildren($order)
    {
        return !MultiVendor\Main::isWarehouseMode()
            && $order
            && $order->isParent()
            && !(bool) $order->getOrderNumber()
            && $order->getChildren();
    }
}
