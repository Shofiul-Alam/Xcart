<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\Paypal\Model;

use XLite\Module\XC\MultiVendor;

/**
 * Class represents an order
 *
 * @Decorator\Depend ("CDev\Paypal")
 */
class Order extends \XLite\Model\Order implements \XLite\Base\IDecorator
{
    /**
     * Set commissions status
     *
     * @param array $commissionNotifications Array of commission transaction from IPN notification
     *
     * @return void
     */
    public function setCommissionsToPaid(array $commissionNotifications)
    {
        if ($this->isParent()) {
            $vendorOrders = array_filter(
                $this->getChildren()->toArray(),
                function ($childOrder) {
                    return null !== $childOrder->getVendor();
                }
            );

            foreach ($commissionNotifications as $commissionNotification) {
                $orderOfReceiver = array_reduce(
                    $vendorOrders,
                    function ($carry, $childOrder) use ($commissionNotification) {
                        $foundReceiver = $childOrder->getVendor()->getPaypalLogin() == $commissionNotification['receiver'];
                        return null === $carry && $foundReceiver
                            ? $childOrder
                            : $carry;
                    },
                    null
                );

                // TODO Check amount
                if ($orderOfReceiver && null !== $orderOfReceiver->getCommission()) {
                    $commission = $orderOfReceiver->getCommission();
                    $commission->setAuto(true);
                    $commission->setStatus(
                        MultiVendor\Model\Commission::STATUS_PAID
                    );

                    $this->createProfileTransaction(
                        $commission->getValue(),
                        'Paypal Adaptive: Commission paid',
                        MultiVendor\Model\ProfileTransaction::PROVIDER_PAYPAL,
                        $orderOfReceiver
                    );
                }
            }
        }
    }
}
