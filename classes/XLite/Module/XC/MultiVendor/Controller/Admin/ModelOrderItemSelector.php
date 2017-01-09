<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Admin;

/**
 * OrderItem model selector controller
 */
class ModelOrderItemSelector extends \XLite\Controller\Admin\ModelOrderItemSelector implements \XLite\Base\IDecorator
{
    /**
     * Returns data condition
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getDataCondition()
    {
        $cnd = parent::getDataCondition();

        $order = $this->getOrder();
        if ($order) {
            $vendors = array();
            if ($order->isSingle()) {
                $vendors = $order->getSingleVendors();

            } elseif (!$order->isParent()) {
                $vendors = array($order->getVendor());
            }

            $result = array();
            foreach ($vendors as $vendor) {
                $result[] = $vendor ? $vendor->getProfileId() : null;
            }

            $cnd->{\XLite\Model\Repo\Product::P_VENDORS} = $result;
        }

        return $cnd;
    }

    /**
     * Returns current order
     *
     * @return \XLite\Model\Order
     */
    protected function getOrder()
    {
        $orderId = \XLite\Core\Request::getInstance()->order_id;

        return \XLite\Core\Database::getRepo('XLite\Model\Order')->find($orderId);
    }
}
