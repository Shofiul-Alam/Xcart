<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\Paypal\Model;

use XLite\Module\XC\MultiVendor;

/**
 * Profile
 *
 * @Decorator\Depend ({"CDev\Paypal", "XC\MultiVendor"})
 */
class Profile extends \XLite\Model\Profile implements \XLite\Base\IDecorator
{
    /**
     * Set paypalLogin
     *
     * @param string $paypalLogin
     * @return Profile
     */
    public function setPaypalLogin($paypalLogin)
    {
        $result = parent::setPaypalLogin($paypalLogin);

        if ($this->isVendor()) {
            $this->renewPaypalLoginStatus();
        }

        return $result;
    }

    /**
     * Set firstName
     *
     * @param string $value
     * @return Profile
     */
    public function setFirstName($value)
    {
        $result = parent::setFirstName($value);

        if ($this->isVendor()) {
            $this->renewPaypalLoginStatus();
        }

        return $result;
    }

    /**
     * Set lastName
     *
     * @param string $value
     * @return Profile
     */
    public function setLastName($value)
    {
        $result = parent::setLastName($value);

        if ($this->isVendor()) {
            $this->renewPaypalLoginStatus();
        }

        return $result;
    }

    /**
     * Process paypal login
     *
     * @return boolean
     */
    public function renewPaypalLoginStatus()
    {
        $api = new \XLite\Module\CDev\Paypal\Core\PaypalAdaptiveAPI();

        $matchCriteria = method_exists($api, 'getMatchCriteria')
            ? $api->getMatchCriteria()
            : null;

        if ($matchCriteria === 'disabled') {
            $this->setPaypalLoginStatus(
                self::PAYPAL_LOGIN_FORCE_VERIFIED
            );

        } else {
            $params = array(
                'paypalLogin' => $this->getPaypalLogin(),
            );

            if (in_array($matchCriteria, array('none', 'name'))) {
                if ($matchCriteria === 'name') {
                    $params = array_merge(
                        $params,
                        array(
                            'firstName' => $this->getFirstName(),
                            'lastName'  => $this->getLastName(),
                        )
                    );
                }
                $response = $api->doGetVerifiedStatusCallWithCriteria(
                    $matchCriteria,
                    $params
                );
            } else {
                $response = $api->doGetVerifiedStatusCall(
                    $this->getPaypalLogin()
                );
            }

            if ($response && strtolower($response['responseEnvelope']['ack']) === 'success') {
                if (strtolower($response['accountStatus']) === 'verified') {
                    $this->setPaypalLoginStatus(
                        self::PAYPAL_LOGIN_VERIFIED
                    );
                } else {
                    $this->setPaypalLoginStatus(
                        self::PAYPAL_LOGIN_EXIST_NOT_VERIFIED
                    );
                }

            } else {
                $this->setPaypalLoginStatus(
                    self::PAYPAL_LOGIN_NOT_EXISTS
                );
            }
        }
    }
}
