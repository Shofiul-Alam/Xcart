<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\AvaTax\Logic\Order\Modifier;

use XLite\Module\XC\MultiVendor;

/**
 * Tax business logic
 *
 * @Decorator\Depend ("XC\AvaTax")
 */
class StateTax extends \XLite\Module\XC\AvaTax\Logic\Order\Modifier\StateTax implements \XLite\Base\IDecorator
{
    /**
     * Calculate
     *
     * @return \XLite\Model\Order\Surcharge[]
     */
    public function calculate()
    {
        $order = $this->getOrder();
        $warehouseMode = MultiVendor\Main::isWarehouseMode();

        return (($order->isChild() && !$warehouseMode) || ($order->isParent() && $warehouseMode))
            ? parent::calculate()
            : null;
    }
}
