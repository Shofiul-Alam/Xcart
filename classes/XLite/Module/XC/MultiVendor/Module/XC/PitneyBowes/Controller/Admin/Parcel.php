<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\PitneyBowes\Controller\Admin;

/**
 * Parcel controller
 * @Decorator\Depend ("XC\PitneyBowes")
 */
class Parcel extends \XLite\Module\XC\PitneyBowes\Controller\Admin\Parcel implements \XLite\Base\IDecorator
{
    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        return parent::checkACL()
            || ($this->getParcel() && \XLite\Core\Auth::getInstance()->isPermissionAllowed('[vendor] manage orders'));
    }

    /**
     * Create asn request
     *
     * @return void
     */
    public function doActionCreateAsn()
    {
        $order = $this->getOrder();

        if ($order->isChild() && $order->getVendor()) {
            $config = \XLite\Module\XC\MultiVendor\Main::getVendorConfiguration(
                $order->getVendor(),
                array('XC', 'PitneyBowes')
            );
            \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::updateConfiguration($config);
        }

        parent::doActionCreateAsn();
    }
}
