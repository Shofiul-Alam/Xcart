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
 * Shipping methods management page controller
 */
abstract class ShippingMethods extends \XLite\Controller\Admin\ShippingMethods implements \XLite\Base\IDecorator
{
    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        $warehouseMode = MultiVendor\Main::isWarehouseMode();

        return parent::checkACL()
            || (Core\Auth::getInstance()->isPermissionAllowed('[vendor] manage shipping') && !$warehouseMode);
    }

    /**
     * Returns shipping method
     *
     * @return null|\XLite\Model\Shipping\Method
     */
    public function getMethod()
    {
        /** @var \XLite\Model\Repo\Shipping\Method $repo */
        $repo = Core\Database::getRepo('XLite\Model\Shipping\Method');

        return $repo->findOnlineCarrierByVendor($this->getProcessorId(), Core\Auth::getInstance()->getVendor());
    }
}
