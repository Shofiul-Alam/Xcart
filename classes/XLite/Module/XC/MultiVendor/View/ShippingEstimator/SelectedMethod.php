<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ShippingEstimator;

use XLite\Module\XC\MultiVendor;

/**
 * Selected shipping method view
 */
class SelectedMethod extends \XLite\View\ShippingEstimator\SelectedMethod implements \XLite\Base\IDecorator
{
    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/XC/MultiVendor/shopping_cart/parts/box.estimator.method.css';

        return $list;
    }

    /**
     * Return current template
     *
     * @return string
     */
    protected function getTemplate()
    {
        return $this->getCart()->isParent() && !MultiVendor\Main::isWarehouseMode()
            ? 'modules/XC/MultiVendor/shopping_cart/parts/box.estimator.method.twig'
            : parent::getTemplate();
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
     * Should be child shipping select visible
     *
     * @return boolean
     */
    protected function isChildVisible(\XLite\Model\Cart $cart)
    {
        $modifier = $cart->getModifier(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, 'SHIPPING');

        return $modifier && $modifier->getMethod();
    }

    protected function isVisible()
    {
        return $this->getCart()->isParent() && !MultiVendor\Main::isWarehouseMode()
            ? true
            : parent::isVisible();
    }
}
