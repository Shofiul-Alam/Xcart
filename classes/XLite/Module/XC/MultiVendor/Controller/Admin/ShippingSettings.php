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
 * Shipping settings management page controller
 */
abstract class ShippingSettings extends \XLite\Controller\Admin\ShippingSettings implements \XLite\Base\IDecorator
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
            || (Core\Auth::getInstance()->isPermissionAllowed('[vendor] manage shipping')
                && !$warehouseMode
                && $this->getMethod()
            );
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

    /**
     * Add online method
     *
     * @param \XLite\Model\Shipping\Method $method Shipping method
     *
     * @return void
     */
    protected function addOnlineMethod($method)
    {
        if (Core\Auth::getInstance()->isVendor() && null === $method) {
            /** @var \XLite\Model\Repo\Shipping\Method $repo */
            $repo = Core\Database::getRepo('XLite\Model\Shipping\Method');
            /** @var \XLite\Model\Shipping\Method $adminMethod */
            $adminMethod = $repo->findOnlineCarrierByVendor($this->getProcessorId(), null);

            if ($adminMethod) {
                $vendor = Core\Auth::getInstance()->getVendor();
                $method = $adminMethod->cloneEntity();
                $method->setVendor($vendor);
                $method->setEnabled(false);
                $method->update();

                $carrierServices = $repo->findMethodsByProcessorAndVendor($this->getProcessorId(), null, false);
                /** @var \XLite\Model\Shipping\Method $carrierService */
                foreach ($carrierServices as $carrierService) {
                    $service = $carrierService->cloneEntity();
                    $service->setVendor($vendor);
                    $service->setEnabled($carrierService->getEnabled());
                    $service->update();
                }
            }
        }

        parent::addOnlineMethod($method);
    }
}
