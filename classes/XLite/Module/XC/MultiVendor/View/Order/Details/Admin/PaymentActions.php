<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Order\Details\Admin;

/**
 * Order info
 */
class PaymentActions extends \XLite\View\Order\Details\Admin\PaymentActions implements \XLite\Base\IDecorator
{
    /**
     * Get list of allowed backend transactions
     *
     * @param \XLite\Model\Payment\Transaction $transaction Payment transaction OPTIONAL
     *
     * @return array
     */
    protected function getTransactionUnits($transaction = null)
    {
        return \XLite\Core\Auth::getInstance()->isVendor()
            ? null
            : parent::getTransactionUnits($transaction);
    }
}
