<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\VolumeDiscounts\Logic\Order\Modifier;

use \XLite\Module\XC\MultiVendor;
use \XLite\Module\CDev\VolumeDiscounts;

/**
 * Value discount modifier
 *
 * @Decorator\Depend ("CDev\VolumeDiscounts")
 */
class Discount extends \XLite\Module\CDev\VolumeDiscounts\Logic\Order\Modifier\Discount implements \XLite\Base\IDecorator
{
    /**
     * Get suitable discount from database
     *
     * @return \XLite\Module\CDev\VolumeDiscounts\Model\VolumeDiscount
     */
    protected function getDiscount()
    {
        $order = $this->getOrder();

        return MultiVendor\Main::isWarehouseMode()
            ? $this->getDiscountInWarehouseMode($order)
            : $this->getDiscountInSeparateMode($order);
    }


    /**
     * Get suitable discount from database
     *
     * @param \XLite\Model\Order $order Order
     *
     * @return \XLite\Module\CDev\VolumeDiscounts\Model\VolumeDiscount
     */
    protected function getDiscountInSeparateMode(\XLite\Model\Order $order)
    {
        $result = null;

        /** @var \XLite\Module\CDev\VolumeDiscounts\Model\Repo\VolumeDiscount $repo */
        $repo = \XLite\Core\Database::getRepo('XLite\Module\CDev\VolumeDiscounts\Model\VolumeDiscount');

        if (!$order->isParent()) {
            $vendorId = $order->getVendor()
                ? $order->getVendor()->getProfileId()
                : \XLite\Model\Repo\Profile::ADMIN_VENDOR_FAKE_ID;

            $cnd = $this->getDiscountCondition();
            $cnd->{VolumeDiscounts\Model\Repo\VolumeDiscount::P_VENDOR_ID} = $vendorId;

            $result = $repo->getFirstDiscount($cnd);
        }

        return $result;
    }

    /**
     * Get suitable discount from database
     *
     * @param \XLite\Model\Order $order Order
     *
     * @return \XLite\Module\CDev\VolumeDiscounts\Model\VolumeDiscount
     */
    protected function getDiscountInWarehouseMode(\XLite\Model\Order $order)
    {
        $result = null;

        /** @var \XLite\Module\CDev\VolumeDiscounts\Model\Repo\VolumeDiscount $repo */
        $repo = \XLite\Core\Database::getRepo('XLite\Module\CDev\VolumeDiscounts\Model\VolumeDiscount');

        if ($order->isParent()) {
            $cnd = $this->getDiscountCondition();
            $cnd->{VolumeDiscounts\Model\Repo\VolumeDiscount::P_VENDOR_ID}
                = \XLite\Model\Repo\Profile::ADMIN_VENDOR_FAKE_ID;

            $result = $repo->getFirstDiscount($cnd);

        } elseif ($order->getVendor()) {
            $cnd = $this->getDiscountCondition();
            $cnd->{VolumeDiscounts\Model\Repo\VolumeDiscount::P_SUBTOTAL}
                = $order->getParent()->getSubtotal();
            $cnd->{VolumeDiscounts\Model\Repo\VolumeDiscount::P_VENDOR_ID}
                = \XLite\Model\Repo\Profile::ADMIN_VENDOR_FAKE_ID;

            $parentDiscount = $repo->getFirstDiscount($cnd);

            if (!$parentDiscount) {
                $cnd = $this->getDiscountCondition();
                $cnd->{VolumeDiscounts\Model\Repo\VolumeDiscount::P_VENDOR_ID}
                    = $order->getVendor()->getProfileId();

                $result = $repo->getFirstDiscount($cnd);
            }
        }

        return $result;
    }
}
