<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ShippingEstimator;

use XLite\Module\XC\MultiVendor;

/**
 * Shipping estimate box
 */
class ShippingEstimateBox extends \XLite\View\ShippingEstimator\ShippingEstimateBox implements \XLite\Base\IDecorator
{
    /**
     * Vendor modifiers cache
     *
     * @var \XLite\Model\Order\Modifier[]
     */
    protected $vendorModifiers = array();

    /**
     * Check - shipping estimate and method selected or not
     *
     * @return boolean
     */
    protected function isShippingEstimate()
    {
        return \XLite\Model\Shipping::getInstance()->getDestinationAddress($this->getModifier()->getModifier())
            && $this->hasMethod();
    }

    /**
     * Check for selected shipping method
     *
     * @return boolean
     */
    protected function hasMethod()
    {
        $result = true;

        /** @var \XLite\Model\Cart $cart */
        $cart = $this->getCart();
        if (!MultiVendor\Main::isWarehouseMode() && $cart->isParent()) {
            /** @var \XLite\Model\Cart $child */
            foreach ($cart->getChildren() as $child) {
                $modifier = $this->getVendorModifier($child);
                if (!$modifier || ($modifier->canApply() && !$modifier->getMethod())) {
                    $result = false;

                    break;
                }
            }
        }

        return $result;
    }

    /**
     * Get shipping modifier for vendor
     *
     * @param \XLite\Model\Cart $cart Cart
     *
     * @return \XLite\Model\Order\Modifier
     */
    protected function getVendorModifier($cart)
    {
        $vendorId = $cart->getVendor() ? $cart->getVendor()->getProfileId() : -1;
        if (!isset($this->vendorModifiers[$vendorId])) {
            $this->vendorModifiers[$vendorId]
                = $cart->getModifier(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, 'SHIPPING');
        }

        return $this->vendorModifiers[$vendorId];
    }
}
