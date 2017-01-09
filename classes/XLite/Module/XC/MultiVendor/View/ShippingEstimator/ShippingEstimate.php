<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ShippingEstimator;

use XLite\Module\XC\MultiVendor;

/**
 * Shipping estimator
 */
class ShippingEstimate extends \XLite\View\ShippingEstimator\ShippingEstimate implements \XLite\Base\IDecorator
{
    /**
     * Vendor modifiers cache
     *
     * @var \XLite\Model\Order\Modifier[]
     */
    protected $vendorModifiers = array();

    /**
     * Returns shipping rates
     *
     * @return boolean
     */
    protected function hasRates()
    {
        $cart = $this->getCart();

        return !MultiVendor\Main::isWarehouseMode() && $cart->isParent()
            ? $this->hasRatesForAllVendors()
            : parent::hasRates();
    }

    /**
     * Check for selected shipping method
     *
     * @return boolean
     */
    protected function hasRatesForAllVendors()
    {
        $result = true;

        /** @var \XLite\Model\Cart $cart */
        $cart = $this->getCart();
        if ($cart->isParent()) {
            /** @var \XLite\Model\Cart $child */
            foreach ($cart->getChildren() as $child) {
                $modifier = $this->getVendorModifier($child);
                if (!$modifier || ($modifier->canApply() && (!$modifier->getMethod() || !$modifier->getRates()))) {
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
