<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View;

use XLite\Core\Auth;

/**
 * Invoice widget
 */
class Invoice extends \XLite\View\Invoice implements \XLite\Base\IDecorator
{
    const PARAM_IS_CHILD = 'isChild';
    const PARAM_DISPLAY_FOR_VENDOR   = 'displayForVendor';

    /**
     * Define widget parameters
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_IS_CHILD => new \XLite\Model\WidgetParam\TypeBool('isChild', false),
            static::PARAM_DISPLAY_FOR_VENDOR
                => new \XLite\Model\WidgetParam\TypeObject('Vendor', null, false, 'XLite\Model\Profile'),
        );
    }

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'modules/XC/MultiVendor/order/invoice/vendor_link/style.css';

        if (
            \XLite\Core\Auth::getInstance()->isVendor()
            && \XLite\Core\Config::getInstance()->XC->MultiVendor->mask_contacts
        ) {
            // Add CSS style to hide customer email on invoice
            $list[] = 'modules/XC/MultiVendor/order/invoice/invoice.css';
        }

        return $list;
    }

    /**
     * Returns isChild flag state
     *
     * @return boolean
     */
    protected function isChild()
    {
        return $this->getParam(static::PARAM_IS_CHILD);
    }

    /**
     * Return default template
     *
     * @return string
     */
    protected function getTemplate()
    {
        return $this->isChild()
            ? parent::getTemplate()
            : 'modules/XC/MultiVendor/order/invoice/parent.twig';
    }

    /**
     * Returns orders list (merge parent with children and filter orders without orderNumber)
     *
     * @return \XLite\Model\Order[]
     */
    protected function getOrders()
    {
        return array_filter(
            array_merge(array($this->getOrder()), $this->getOrder()->getChildren()->toArray()),
            function ($item) {
                return $item && (bool) $item->getOrderNumber();
            }
        );
    }

    /**
     * Returns current vendor
     *
     * @return \XLite\Model\Profile
     */
    protected function getVendor()
    {
        return $this->getParam(static::PARAM_DISPLAY_FOR_VENDOR) ?:
            (\XLite::isAdminZone() ? Auth::getInstance()->getVendor() : null);
    }

    /**
     * Check if invoice for vendor
     *
     * @return boolean
     */
    protected function isVendor()
    {
        return (bool) $this->getVendor();
    }

    /**
     * Returns invoice title
     *
     * @return string
     */
    protected function getInvoiceTitle()
    {
        $order = $this->getOrder();
        $vendor = $this->getVendor();

        return $vendor
            && ((!$order->getVendor() || $order->getVendor()->getProfileId() !== $vendor->getProfileId())
                || $order->isSingle()
            ) ? static::t('Order X', array('id' => $this->getOrder()->getOrderNumber()))
            : parent::getInvoiceTitle();
    }

    /**
     * Returns order items
     *
     * @return \XLite\Model\OrderItem[]
     */
    protected function getOrderItems()
    {
        $order = $this->getOrder();
        $vendor = $this->getVendor();

        return $vendor
            && ((!$order->getVendor() || $order->getVendor()->getProfileId() !== $vendor->getProfileId())
                || $order->isSingle()
            ) ? array_filter(parent::getOrderItems()->toArray(), function ($item) use ($vendor) {
                /** @var \XLite\Model\OrderItem $item */
                return $item->getVendor() && $item->getVendor()->getProfileId() === $vendor->getProfileId();
            })
            : parent::getOrderItems();
    }

    /**
     * Get order formatted subtotal
     *
     * @return string
     */
    protected function getOrderSubtotal()
    {
        $order = $this->getOrder();
        $result = $order->getSubtotal();
        $vendor = $this->getVendor();

        if ($vendor) {
            if ($order->isSingle()) {
                $result = array_reduce($order->getItems()->toArray(), function ($carry, $item) use ($vendor) {
                    $ofCurrentVendor = $item->getVendor()
                        && $item->getVendor()->getProfileId() === $vendor->getProfileId();

                    return $carry + ($ofCurrentVendor ? $item->getTotal() : 0);
                }, 0);

            } elseif (!$order->getVendor() || $order->getVendor()->getProfileId() !== $vendor->getProfileId()) {
                $result = $order->getChildByVendor($vendor)->getSubtotal();
            }
        }

        return static::formatPrice($result, $order->getCurrency(), true);
    }

    /**
     * Get order formatted subtotal
     *
     * @return string
     */
    protected function getOrderTotal()
    {
        $order = $this->getOrder();
        $result = $order->getTotal();
        $vendor = $this->getVendor();

        if ($vendor) {
            if ($order->isSingle()) {
                $itemsResult = array_reduce(
                    $order->getItems()->toArray(),
                    function ($carry, $item) use ($vendor) {
                        $ofCurrentVendor = $item->getVendor()
                            && $item->getVendor()->getProfileId() === $vendor->getProfileId();

                        return $carry + ($ofCurrentVendor ? $item->getTotal() : 0);
                    },
                    0
                );

                $surchargesResult = array_reduce(
                    $order->getSurcharges()->toArray(),
                    function ($carry, $item) use ($vendor) {
                        $ofCurrentVendor = $item->getVendor()
                            && $item->getVendor()->getProfileId() === $vendor->getProfileId();

                        return $carry + ($ofCurrentVendor ? $item->getValue() : 0);
                    },
                    0
                );

                $result = $itemsResult + $surchargesResult;

            } elseif (!$order->getVendor() || $order->getVendor()->getProfileId() !== $vendor->getProfileId()) {
                $result = $order->getChildByVendor($vendor)->getTotal();
            }
        }

        return static::formatPrice($result, $order->getCurrency(), true);
    }

    /**
     * Get surcharge totals
     *
     * @return array
     */
    protected function getSurchargeTotals()
    {
        $order = $this->getOrder();
        $vendor = $this->getVendor();

        if ($vendor
            && (!$order->getVendor() || $order->getVendor()->getProfileId() !== $vendor->getProfileId())
        ) {
            $child = $order->getChildByVendor($vendor);
            $result = $child ? $child->getSurchargeTotals() : array();

        } else {
            $result = parent::getSurchargeTotals();
        }

        return $result;
    }

    /**
     * Check if vendors product is detached from order item
     *
     * @param \XLite\Model\OrderItem $entity Order item
     *
     * @return boolean
     */
    protected function isDetachedOrderItem($entity)
    {
        return Auth::getInstance()->isVendor() && $entity->getOriginalProduct();
    }

    /**
     * Return specific data for address entry. Helper.
     *
     * @param \XLite\Model\Address $address   Address
     * @param boolean              $showEmpty Show empty fields OPTIONAL
     *
     * @return array
     */
    protected function getAddressSectionData(\XLite\Model\Address $address, $showEmpty = false)
    {
        $data = parent::getAddressSectionData($address, $showEmpty);

        $currentLogin = $this->getParam(static::PARAM_DISPLAY_FOR_VENDOR)
            ? $this->getParam(static::PARAM_DISPLAY_FOR_VENDOR)->getLogin()
            : (
                \XLite\Core\Auth::getInstance()->getProfile()
                    ? \XLite\Core\Auth::getInstance()->getProfile()->getLogin()
                    : null
            );

        if (
            \XLite\Core\Config::getInstance()->XC->MultiVendor->mask_contacts
            && is_array($data)
            && $address
            && array_intersect(array_keys($data), $this->getUnallowedProfileFields())
            && (\XLite\Core\Auth::getInstance()->isVendor() || $this->getParam(static::PARAM_DISPLAY_FOR_VENDOR))
            && $address->getProfile()->getLogin() != $currentLogin
        ) {
            // Remove unallowed fields
            foreach ($this->getUnallowedProfileFields() as $f) {
                if (isset($data[$f])) {
                    unset($data[$f]);
                }
            }
        }

        return $data;
    }

}
