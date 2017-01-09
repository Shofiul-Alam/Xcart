<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Admin;

use XLite\Core;
use XLite\Module\XC\MultiVendor;

/**
 * Shipping rates page controller
 */
abstract class ShippingRates extends \XLite\Controller\Admin\ShippingRates implements \XLite\Base\IDecorator
{
    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        $warehouseMode = MultiVendor\Main::isWarehouseMode();
        $method = $this->getModelForm()->getModelObject();

        return parent::checkACL()
            || (Core\Auth::getInstance()->isPermissionAllowed('[vendor] manage shipping')
                && !$warehouseMode
                && $method->isOfCurrentVendor()
            );
    }
}
