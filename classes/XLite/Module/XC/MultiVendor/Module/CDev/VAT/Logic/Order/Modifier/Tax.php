<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\VAT\Logic\Order\Modifier;

use XLite\Module\XC\MultiVendor;

/**
 * Tax business logic
 *
 * @Decorator\Depend ("CDev\VAT")
 */
class Tax extends \XLite\Module\CDev\VAT\Logic\Order\Modifier\Tax implements \XLite\Base\IDecorator
{
    /**
     * Calculate
     *
     * @return \XLite\Model\Order\Surcharge
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
