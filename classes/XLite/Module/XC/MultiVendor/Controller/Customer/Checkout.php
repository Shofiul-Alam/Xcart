<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Customer;

use XLite\Core;
use XLite\Module\XC\MultiVendor;

/**
 * Checkout controller
 */
class Checkout extends \XLite\Controller\Customer\Checkout implements \XLite\Base\IDecorator
{
    /**
     * Process cart profile
     * Clone profile for children orders
     *
     * @param boolean $doCloneProfile Clone profile flag
     *
     * @return boolean
     */
    protected function processCartProfile($doCloneProfile)
    {
        $isAnonymous = parent::processCartProfile($doCloneProfile);

        $cart = $this->getCart();
        if ($cart->isParent()) {
            foreach ($cart->getChildren() as $child) {
                $child->setOrigProfile($cart->getOrigProfile());

                if ($doCloneProfile && $this->isAllowedCloneProfile($cart)) {
                    $profile = $cart->getProfile()->cloneEntity();
                    $child->setProfile($profile);
                    $profile->setOrder($child);
                }
            }

            Core\Database::getEM()->flush();
        }

        return $isAnonymous;
    }

    /**
     * Return true if profile can be cloned
     *
     * @param \XLite\Model\Order $order Order model object
     *
     * @return boolean
     */
    protected function isAllowedCloneProfile($order)
    {
        return true;
    }

    /**
     * Change shipping method
     *
     * @return void
     */
    protected function doActionShipping()
    {
        $cart = $this->getCart();
        $methodId = Core\Request::getInstance()->methodId;

        if (is_array($methodId) && $cart->isParent() && !MultiVendor\Main::isWarehouseMode()) {
            /** @var \XLite\Model\Cart $child */
            foreach ($cart->getChildren() as $child) {
                if (isset($methodId[$child->getOrderId()])) {
                    $childMethodId = $methodId[$child->getOrderId()];
                    $child->setLastShippingId($childMethodId);
                    $child->setShippingId($childMethodId);
                }
            }

            $this->updateCart();

        } else {
            parent::doActionShipping();
        }
    }

    /**
     * Change shipping method
     *
     * @return void
     */
    protected function doActionRemoveVendorsProducts()
    {
        $vendors = $this->getCart()->getVendorsWithoutRates();

        foreach ($vendors as $vendor) {
            $vendorCart = $this->getCart()->getChildByVendor($vendor);

            if ($vendorCart) {
                $orderItems = $vendorCart->getItems();
                foreach ($orderItems as $orderItem) {
                    if ($orderItem->isShippable()) {
                        $vendorCart->getItems()->removeElement($orderItem);
                        \XLite\Core\Database::getEM()->remove($orderItem);
                    }
                }
            }
        }

        $this->updateCart();
        if ($this->isAJAX()) {
            $this->silent = true;
        } else {
            $this->setHardRedirect(true);
            $this->setReturnURL($this->buildURL('checkout'));
        }
    }
}
