<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\FastLaneCheckout\View\Blocks;

/**
 * Checkout Address form
 *
 * @Decorator\Depend("XC\FastLaneCheckout")
 */
class ShippingMethods extends \XLite\Module\XC\FastLaneCheckout\View\Blocks\ShippingMethods implements \XLite\Base\IDecorator
{
    /**
     * Get JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        if (!$this->isWarehouseMode()) {
            $list[] = 'modules/XC/MultiVendor/blocks/shipping_methods/shipping-methods.js';
        }

        return $list;
    }

    /**
     * @return boolean
     */
    public function isWarehouseMode()
    {
        return \XLite\Module\XC\MultiVendor\Main::isWarehouseMode();
    }

    /**
     * Returns cart vendor name
     *
     * @param \XLite\Model\Cart $cart
     *
     * @return string
     */
    protected function getVendorName(\XLite\Model\Cart $cart)
    {
        $vendor = $cart->getVendor();

        return null === $vendor
            ? static::t('Administrator')
            : ($vendor->getVendorCompanyName() ?: static::t('na_vendor'));
    }

    /**
     * @return string
     */
    public function getVendorsList()
    {
        if (!$this->isWarehouseMode()) {
            $result = array();
            foreach ($this->getCart()->getChildren() as $child) {
                $result[$child->getOrderId()] = (string) $this->getVendorName($child);
            }

            return json_encode($result);
        }

        return "undefined";
    }

    /**
     * @return string
     */
    public function defineWidgetData()
    {
        $result = parent::defineWidgetData();

        if (!$this->isWarehouseMode()) {
            $methodIds = array();

            foreach ($this->getCart()->getChildren() as $child) {
                if ($child->hasShippableProducts()) {
                    $methodIds[$child->getOrderId()] = (string) $child->getShippingId();
                }
            }

            $result = array_merge(
                $result,
                array(
                    'methodId' => $methodIds
                )
            );
        }

        return $result;
    }
}
