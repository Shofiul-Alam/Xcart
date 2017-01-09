<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Checkout;

/**
 * Shipping methods list
 *
 * @ListChild (list="checkout.review.selected", weight="20")
 */
class PlaceOrderPlaceholder extends \XLite\View\AView
{
    /**
     * Add widget specific CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'modules/XC/MultiVendor/place_order_placeholder/style.css';

        return $list;
    }

    /**
     * Get JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'modules/XC/MultiVendor/place_order_placeholder/controller.js';

        return $list;
    }


    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/XC/MultiVendor/place_order_placeholder/body.twig';
    }

    /**
     * Check if modifier can apply
     *
     * @return boolean
     */
    protected function modifierCanApply()
    {
        $modifier = $this->getCart()->getModifier(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, 'SHIPPING');

        return $modifier && $modifier->canApply();
    }

    // {{{

    /**
     * Get commented data
     *
     * @return array
     */
    protected function getCommentedData()
    {
        return array(
            'isVisible' => $this->isVisibleData(),
        );
    }

    /**
     * Is visible for commented data
     *
     * @return boolean
     */
    protected function isVisibleData()
    {
        return $this->modifierCanApply()
            && $this->getCart()->getVendorsWithoutRates();
    }

    /**
     * Remove action URL
     *
     * @return string
     */
    protected function getRemoveActionURL()
    {
        return $this->buildURL('checkout', 'removeVendorsProducts');
    }

    /**
     * Vendors list
     *
     * @return string
     */
    protected function getVendorsList()
    {
        $vendors = $this->getCart()->getVendorsWithoutRates();
        $vendorsNames = array_map(function($vendor) {
            return $vendor->getVendorCompanyName() ?: 'na_vendor';
        }, $vendors);

        return implode(', ', $vendorsNames);
    }

    /**
     * Should be able to remove products
     *
     * @return boolean
     */
    protected function shouldBeAbleToRemove()
    {
        return $this->getCart()->hasAdminProducts()
            || $this->getCart()->getVendorsWithRates()
            || $this->hasNotShippableProducts();
    }

    /**
     * Should be able to remove products
     *
     * @return boolean
     */
    protected function hasShippableProducts()
    {
        $items = $this->getCart()->getItems()->toArray();

        return array_reduce($items, function ($carry, $item) {
            return $carry ?: $item->isShippable();
        }, false);
    }

    /**
     * Should be able to remove products
     *
     * @return boolean
     */
    protected function hasNotShippableProducts()
    {
        $items = $this->getCart()->getItems()->toArray();

        return array_reduce($items, function ($carry, $item) {
            return $carry ?: !$item->isShippable();
        }, false);
    }

    /**
     * Contact us phone
     *
     * @return string
     */
    protected function getContactUsPhone()
    {
        return \XLite\Core\Config::getInstance()->Company->company_phone;
    }

    // }}}
}
