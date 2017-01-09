<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\Paypal\View\FormField\Input;

use \XLite\Module\CDev\Paypal;

/**
 * PaypalLogin input
 *
 * @Decorator\Depend ("CDev\Paypal")
 */
class PaypalLogin extends \XLite\Module\XC\MultiVendor\View\FormField\Input\PaypalLogin implements \XLite\Base\IDecorator
{
    /**
     * getValue
     *
     * @return string
     */
    public function isCheckAvailable()
    {
        $method = Paypal\Main::getPaymentMethod(
            Paypal\Main::PP_METHOD_PAD
        );

        return !$method->isConfigured($method) || $method->getSetting('matchCriteria') === 'disabled';
    }
}
