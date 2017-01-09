<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View;

use XLite\Module\XC\MultiVendor;

/**
 * Shipping list
 *
 * @Decorator\Before("XC\MultiVendor")
 */
class ShippingList extends \XLite\View\ShippingList implements \XLite\Base\IDecorator
{
    /**
     * Get CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        if (!MultiVendor\Main::isWarehouseMode()) {
            $list[] = 'modules/XC/MultiVendor/shipping_list/style.less';
        }

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getTemplate()
    {
        return $this->getCart()->isChild() || MultiVendor\Main::isWarehouseMode()
            ? parent::getTemplate()
            : 'modules/XC/MultiVendor/shipping_list/body.twig';
    }

    /**
     * Return shipping list widget class name. Should be a child of XLite\View\ShippingList class
     *
     * @return string
     */
    protected function getShippingListWidgetClass()
    {
        return 'XLite\\View\\ShippingList';
    }

    /**
     * Check - display shipping list as select-box or as radio buttons list
     *
     * @return boolean
     */
    protected function isDisplaySelector()
    {
        return !MultiVendor\Main::isWarehouseMode()
            ? 1 < count($this->getRates())
            : parent::isDisplaySelector();
    }

    /**
     * Return children carts
     *
     * @return \XLite\Model\Cart[]
     */
    protected function getChildren()
    {
        return $this->getCart()->getChildren();
    }

    /**
     * Returns cart vendor name
     *
     * @param \XLite\Model\Cart $cart
     *
     * @return string
     */
    protected function getVendorName(\XLite\Model\Cart $cart)
    {
        $vendor = $cart->getVendor();

        return null === $vendor
            ? static::t('Administrator')
            : ($vendor->getVendorCompanyName() ?: static::t('na_vendor'));
    }

    /**
     * Returns field name
     *
     * @return string
     */
    protected function getFieldName()
    {
        return MultiVendor\Main::isWarehouseMode()
            ? parent::getFieldName()
            : sprintf('%s[%d]', parent::getFieldName(), $this->getCart()->getOrderId());
    }

    /**
     * Returns field id
     *
     * @param \XLite\Model\Shipping\Rate $rate Rate
     *
     * @return string
     */
    protected function getFieldId(\XLite\Model\Shipping\Rate $rate)
    {
        return MultiVendor\Main::isWarehouseMode()
            ? parent::getFieldId($rate)
            : sprintf('%s_%d', parent::getFieldId($rate), $this->getCart()->getOrderId());
    }
}
