<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\Paypal\Model;

use \XLite\Module\CDev\Paypal;

/**
 * Paypal Adaptive payment processor
 * 
 * @Decorator\Depend ("CDev\Paypal")
 */
class PaypalAdaptive extends \XLite\Module\CDev\Paypal\Model\Payment\Processor\PaypalAdaptive implements \XLite\Base\IDecorator
{
    /**
     * Process callback
     *
     * @param \XLite\Model\Payment\Transaction $transaction Callback-owner transaction
     *
     * @return void
     */
    public function processCallback(\XLite\Model\Payment\Transaction $transaction)
    {
        $this->processCommissionsByCallback($transaction);

        parent::processCallback($transaction);
    }

    /**
     * Process commissions by received from paypal IPN callback
     *
     * @param \XLite\Model\Payment\Transaction $transaction Callback-owner transaction
     *
     * @return void
     */
    protected function processCommissionsByCallback(\XLite\Model\Payment\Transaction $transaction)
    {
        $requestData = \XLite\Core\Request::getInstance()->getPostDataWithArrayValues();

        $commissionNotifications = array_filter(
            $requestData['transaction'],
            function($transaction){
                return !filter_var($transaction['is_primary_receiver'], FILTER_VALIDATE_BOOLEAN);
            }
        );

        $transaction->getOrder()->setCommissionsToPaid(
            $commissionNotifications
        );
    }
}
