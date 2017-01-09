<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\Paypal\Model;

use \XLite\Module\CDev\Paypal;

/**
 * Paypal adaptive API
 * 
 * @Decorator\Depend ("CDev\Paypal")
 */
class PaypalAdaptiveAPI extends \XLite\Module\CDev\Paypal\Core\PaypalAdaptiveAPI implements \XLite\Base\IDecorator
{
    /**
     * Get receiver of chained payment
     * 
     * @param \XLite\Model\Order $order Order for generation receiver
     * 
     * @return array Receiver associative array
     */
    protected function getReceiver(\XLite\Model\Order $order){
        $receiver = null;

        if (null !== $order->getVendor() && null !== $order->getCommission()) {
            $paypalLogin = $order->getVendor()->getPaypalLogin();

            if (
                !empty($paypalLogin)
                && $order->getVendor()->isVerifiedPaypalLogin()
            ) {
                $receiver = array(
                    'amount'    => round($order->getCommission()->getValue(), 2),
                    'email'     => $paypalLogin
                );
            } else {
                $order->getVendor()->renewPaypalLoginStatus();
                Paypal\Main::addLog(
                    'getReceiver(): Paypal login not found or it is not verified',
                    $order->getVendor()->getLogin()
                );
            }
        }

        return $receiver;
    }

    /**
     * Get secondary receivers
     * 
     * @param \XLite\Model\Order $order Order
     * 
     * @return array
     */
    protected function getSecondaryReceivers(\XLite\Model\Order $order)
    {
        $receivers = array();

        foreach ($order->getChildren() as $childOrder) {
            if (count($receivers) >= static::PAYPAL_ADAPTIVE_MAX_RECEIVERS) {
                break;
            }
            $receivers[] = $this->getReceiver($childOrder);
        }

        return $receivers;
    }

    /**
     * Check if transaction should be chained of not
     * 
     * @param \XLite\Model\Order $order Order
     * 
     * @return boolean
     */
    protected function isChained(\XLite\Model\Order $order)
    {
        return $order->isParent() && $order->hasItemsByVendors();
    }
}
