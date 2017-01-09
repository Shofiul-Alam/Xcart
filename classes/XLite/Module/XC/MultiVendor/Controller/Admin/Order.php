<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Admin;

use XLite\Core\Auth;
use XLite\Model\Role\Permission;

/**
 * Order page controller
 */
abstract class Order extends \XLite\Controller\Admin\Order implements \XLite\Base\IDecorator
{
    /**
     * Create temporary order
     *
     * @param integer $orderId Order ID
     *
     * @return \XLite\Model\Order
     */
    protected static function createTemporaryOrder($orderId)
    {
        $parent = parent::createTemporaryOrder($orderId);
        $order = \XLite\Core\Database::getRepo('XLite\Model\Order')->find($orderId);

        if ($order->isChild() && $order->getVendor()) {
            $parent->setVendor($order->getVendor());
            $parent->setParent($order->getParent());
        }

        return $parent;
    }

    /**
     * Remove temporary order
     *
     * @param \XLite\Model\Order $order Order
     *
     * @return void
     */
    protected function removeTemporaryOrder(\XLite\Model\Order $order)
    {
        if ($order->isParent()) {
            foreach ($order->getChildren() as $child) {
                parent::removeTemporaryOrder($child);
            }
        }

        parent::removeTemporaryOrder($order);
    }

    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        return parent::checkACL() || Auth::getInstance()->isPermissionAllowed('[vendor] manage orders');
    }

    /**
     * Get pages sections
     * Allow only "default" section for vendor and warehouse order
     *
     * @return array
     */
    public function getPages()
    {
        return Auth::getInstance()->isVendor()
            && $this->getOrder()
            && (!$this->getOrder()->isOfCurrentVendor() || $this->getOrder()->isSingle())
                ? array_intersect_key(parent::getPages(), array_flip(array('default')))
                : parent::getPages();
    }

    /**
     * Check if current page is accessible
     * todo: add method like isRootAccessAllowed in \XLite\Core\Auth
     *
     * @return boolean
     */
    public function checkAccess()
    {
        return parent::checkAccess()
            && $this->getOrder()
            && ($this->getOrder()->isOfCurrentVendor() || $this->getOrder()->hasChildOfCurrentVendor()
                || Auth::getInstance()->isPermissionAllowed(Permission::ROOT_ACCESS)
                || Auth::getInstance()->isPermissionAllowed('manage orders')
            );
    }

    /**
     * Return true if order can be edited
     * Allow edit order only for admin or vendors own order
     *
     * @return boolean
     */
    public function isOrderEditable()
    {
        $order = $this->getOrder();

        return parent::isOrderEditable()
            && (Auth::getInstance()->isPermissionAllowed(Permission::ROOT_ACCESS)
                || ($order && $order->isOfCurrentVendor() && !$order->isParent())
            )
            && !($order->isSingle() && $order->getSingleVendors()->count() > 1);
    }

    /**
     * Update order items list
     *
     * @param \XLite\Model\Order $order Order object
     *
     * @return void
     */
    protected function updateOrderItems($order)
    {
        parent::updateOrderItems($order);

        if ($order->isParent() && 'update' === $this->getAction()) {
            $this->filterEmptyOrders($order);
        }
    }

    /**
     * Remove children orders with empty items list
     *
     * @param \XLite\Model\Order $order      Order
     *
     * @return \XLite\Model\Order
     */
    protected function filterEmptyOrders(\XLite\Model\Order $order)
    {
        $children = $order->getChildren();

        /** @var \XLite\Model\Order $child */
        foreach ($children as $child) {
            if (0 === $child->getItems()->count()) {
                \XLite\Core\Database::getRepo('XLite\Model\Order')->delete($child);
            }
        }

        return $order;
    }
}
