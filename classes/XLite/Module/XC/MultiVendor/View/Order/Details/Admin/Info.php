<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Order\Details\Admin;

use XLite\Core\Auth;
use XLite\Core\Config;

/**
 * Order info
 */
class Info extends \XLite\View\Order\Details\Admin\Info implements \XLite\Base\IDecorator
{
    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'modules/XC/MultiVendor/order/page/style.css';

        return $list;
    }

    /**
     * Check - has profile separate modification page or not
     *
     * @return boolean
     */
    protected function hasProfilePage()
    {
        return Auth::getInstance()->isVendor() ? false : parent::hasProfilePage();
    }

    /**
     * Get order formatted subtotal
     *
     * @return string
     */
    protected function getOrderSubtotal()
    {
        $auth = Auth::getInstance();
        $order = $this->getOrder();

        $result = $order->getSubtotal();

        if ($auth->isVendor()) {
            if ($order->isSingle()) {
                $result = array_reduce($order->getItems()->toArray(), function ($carry, $item) {
                    return $carry + ($item->isOfCurrentVendor() ? $item->getTotal() : 0);
                }, 0);

            } elseif (!$order->isOfCurrentVendor()) {
                $result = $order->getChildByVendor(Auth::getInstance()->getVendor())->getSubtotal();
            }
        }

        return $this->formatPriceHTML($result, $order->getCurrency());
    }

    /**
     * Get order formatted subtotal
     *
     * @return string
     */
    protected function getOrderTotal()
    {
        $auth = Auth::getInstance();
        $order = $this->getOrder();

        $result = $order->getTotal();

        if ($auth->isVendor()) {
            if ($order->isSingle()) {
                $itemsResult = array_reduce(
                    $order->getItems()->toArray(),
                    function ($carry, $item) {
                        return $carry + ($item->isOfCurrentVendor() ? $item->getTotal() : 0);
                    },
                    0
                );

                $surchargesResult = array_reduce(
                    $order->getSurcharges()->toArray(),
                    function ($carry, $item) {
                        return $carry + ($item->isOfCurrentVendor() ? $item->getValue() : 0);
                    },
                    0
                );

                $result = $itemsResult + $surchargesResult;

            } elseif (!$order->isOfCurrentVendor()) {
                $result = $order->getChildByVendor($auth->getVendor())->getTotal();
            }
        }

        return $this->formatPriceHTML($result, $order->getCurrency());
    }

    /**
     * Get profile email
     *
     * @return string
     */
    protected function getProfileEmail()
    {
        return Auth::getInstance()->isVendor() && Config::getInstance()->XC->MultiVendor->mask_contacts
            ? ''
            : parent::getProfileEmail();
    }
}
