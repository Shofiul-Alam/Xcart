<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Checkout;

use XLite\Module\XC\MultiVendor;

/**
 * Shipping methods list
 */
abstract class ShippingMethodsList extends \XLite\View\Checkout\ShippingMethodsList implements \XLite\Base\IDecorator
{
    /**
     * Check - shipping rates is available or not
     *
     * @return boolean
     */
    public function isShippingAvailable()
    {
        $result = parent::isShippingAvailable();

        $cart = $this->getCart();
        if ($result
            && !MultiVendor\Main::isWarehouseMode()
            && $cart->isParent()
        ) {
            /** @var \Xlite\Model\Cart $child */
            foreach ($this->getCart()->getChildren() as $child) {
                if (!$child) {
                    continue;
                }

                $modifier = $child->getModifier(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, 'SHIPPING');

                if ($modifier && $modifier->canApply() && !$modifier->isRatesExists()) {
                    $result = false;

                    break;
                }
            }
        }

        return $result;
    }

    /**
     * Error message for JS event
     *
     * @return string
     */
    protected function getErrorMessage()
    {
        return $this->getCart()->hasItemsByVendors()
            ? static::t('Sorry, your order cannot be placed: Some of the sellers do not have a shipping method available')
            : parent::getErrorMessage();
    }

    /**
     * No shippings methods available notification
     *
     * @return string
     */
    protected function getShippingNotAvailableNotification()
    {
        $vendors = $this->getCart()->getVendorsWithoutRates();

        $notification = parent::getShippingNotAvailableNotification();

        if ($vendors) {
            $vendorsNames = array_map(function($vendor) {
                return $vendor->getVendorCompanyName() ?: 'na_vendor';
            }, $vendors);

            $notification = static::t(
                'The following vendors have no shipping methods available: vendors',
                array(
                    'vendors' => implode(', ', $vendorsNames)
                )
            );
        }

        return $notification;
    }
}
