<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\NotFinishedOrders\Model;

/**
 * Order model extension
 *
 * @Decorator\Depend ("XC\NotFinishedOrders")
 */
class Cart extends \XLite\Model\Cart implements \XLite\Base\IDecorator
{
    /**
     * Set new cart object
     *
     * @param \XLite\Model\Order $object Cart object to set
     *
     * @return void
     */
    protected function setNewCart(\XLite\Model\Order $object)
    {
        if ($object->isParent()) {
            parent::setNewCart($object);
        }
    }

    /**
     * Return true if NFO order should be created on order failure
     *
     * @param mixed $paymentStatus Payment status
     *
     * @return boolean
     */
    protected function isNeedProcessNFO($paymentStatus)
    {
        return parent::isNeedProcessNFO($paymentStatus)
            && $this->isParent();
    }

    /**
     * Method to turn not finished cart to order and generate new cart.
     * Return new cart model.
     *
     * @param boolean $placeMode Flag: true - process NFO on place order action; false - on payment failure
     *
     * @return \XLite\Model\Cart
     */
    public function processNotFinishedOrder($placeMode = false)
    {
        $newCart = parent::processNotFinishedOrder($placeMode);

        if ($this->isParent()) {

            foreach ($this->getChildren() as $child) {
                $newChild = $child->processNotFinishedOrder($placeMode);
                if ($newChild) {
                    $newChild->setParent($newCart);
                    $newCart->addChildren($newChild);
                }
            }
        }

        return $newCart;
    }

    /**
     * Remove not finished order
     *
     * @param boolean $force Force removing of NFO flag OPTIONAL
     *
     * @return void
     */
    public function removeNotFinishedOrder($force = false)
    {
        if ($this->isParent()) {
            foreach ($this->getChildren() as $child) {
                $child->removeNotFinishedOrder($force);
            }
        }

        $order = $this->getNotFinishedOrder();

        if ($order && $this->canRemoveNotFinishedOrder($order)) {
            // Remove and unset commission of NFO
            $commission = $order->getCommission();
            if ($commission) {
                $order->setCommission(null);
                \XLite\Core\Database::getEM()->remove($commission);
            }

            // Remove and unset profile linked to NFO
            $profile = $order->getNativeProfile();
            if ($profile) {
                $order->setNativeProfile(null);
                \XLite\Core\Database::getEM()->remove($profile);
            }
        }

        parent::removeNotFinishedOrder($force);
    }

    /**
     * Process cloned not finished order
     *
     * @param \XLite\Model\Order $cart Cloned order entity
     *
     * @return \XLite\Model\Order
     */
    protected function processNFOClonedEntity($cart)
    {
        if ($this->isChild()) {
    
            $userProfile = $this->getNativeProfile();

            $this->setNativeProfile($cart->getNativeProfile());

            if ($userProfile) {
                $userProfile->setOrder(null);
            }

            $cart->setNativeProfile(null);
            $cart->setOrigProfile(null);
            $this->getNativeProfile()->setOrder($this);

        } else {
            $cart = parent::processNFOClonedEntity($cart);
        }

        return $cart;
    }

    /**
     * Remove relation between this order and other order linked to this by not_finished_order_id
     *
     * @return \XLite\Model\Order
     */
    protected function closeLinkedOrder()
    {
        if ($this->isParent()) {

            foreach ($this->getChildren() as $child) {

                $cart = \XLite\Core\Database::getRepo('XLite\Model\Cart')->findOneBy(
                    array(
                        'not_finished_order' => $child->getOrderId()
                    )
                );

                if ($cart) {
                    $cart->setNotFinishedOrder(null);
                }
            }
        }

        return parent::closeLinkedOrder();
    }

    /**
     * Disable clone of children for cart model object
     *
     * @return boolean
     */
    protected function isNeedCloneChildren()
    {
        return false;
    }
}
