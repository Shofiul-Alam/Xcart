<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Customer;

use XLite\Core;
use XLite\Module\XC\MultiVendor;

/**
 * Shipping estimator
 */
class ShippingEstimate extends \XLite\Controller\Customer\ShippingEstimate implements \XLite\Base\IDecorator
{
    /**
     * Change shipping method
     *
     * @return void
     */
    protected function doActionChangeMethod()
    {
        $cart = $this->getCart();
        $methodId = Core\Request::getInstance()->methodId;

        if (is_array($methodId) && $cart->isParent() && !MultiVendor\Main::isWarehouseMode()) {
            /** @var \XLite\Model\Cart $child */
            foreach ($cart->getChildren() as $child) {
                if (isset($methodId[$child->getOrderId()])) {
                    $childMethodId = $methodId[$child->getOrderId()];
                    $child->setLastShippingId($childMethodId);
                    $child->setShippingId($childMethodId);
                }
            }

            Core\Request::getInstance()->methodId = 0;
        }

        parent::doActionChangeMethod();
        $this->updateCart();
    }
}
