<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ItemsList\Model;

use XLite\Core\Auth;

/**
 * OrderItem items list
 */
abstract class OrderItem extends \XLite\View\ItemsList\Model\OrderItem implements \XLite\Base\IDecorator
{
    /**
     * Process create new entities
     */
    protected function processCreate()
    {
        parent::processCreate();

        $order = $this->getOrder();
        $orderItems = $order->getSelfItems();

        if ($order->isParent()) {
            foreach ($orderItems as $orderItem) {
                $vendor = $orderItem->getVendor();
                $child = $order->getChildByVendor($vendor) ?: $order->createChildForVendor($vendor);
                $child->setIsOrder(true);

                $order->getItems()->removeElement($orderItem);
                $orderItem->setOrder($child);
                $child->addItems($orderItem);

                $orderItem->update();
            }
        }
    }

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'modules/XC/MultiVendor/order/invoice/vendor_link/style.css';

        return $list;
    }

    /**
     * Check if vendors product is detached from order item
     *
     * @param \XLite\Model\OrderItem $entity Order item
     *
     * @return boolean
     */
    protected function isDetachedOrderItem($entity)
    {
        return Auth::getInstance()->isVendor() && $entity->getOriginalProduct();
    }
}
