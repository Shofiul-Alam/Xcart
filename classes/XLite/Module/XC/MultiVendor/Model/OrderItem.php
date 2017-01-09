<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model;

use XLite\Core;

/**
 * Something customer can put into his cart
 */
class OrderItem extends \XLite\Model\OrderItem implements \XLite\Base\IDecorator
{
    /**
     * Vendor - owner of the product (relation)
     *
     * @var \XLite\Model\Profile
     *
     * @ManyToOne  (targetEntity="XLite\Model\Profile")
     * @JoinColumn (name="vendor_id", referencedColumnName="profile_id", onDelete="SET NULL")
     */
    protected $vendor;

    /**
     * Object (product)
     *
     * @var \XLite\Model\Product
     *
     * @ManyToOne  (targetEntity="XLite\Model\Product", cascade={"merge","detach"})
     * @JoinColumn (name="originalProductId", referencedColumnName="product_id", onDelete="SET NULL")
     */
    protected $originalProduct;

    /**
     * Check if current vendor has access to this order
     *
     * @return boolean
     */
    public function isOfCurrentVendor()
    {
        $auth = Core\Auth::getInstance();

        return $this->getProduct()
            ? $this->getProduct()->isOfCurrentVendor()
            : $auth->isVendor() && $auth->getVendor() == $this->getVendor();
    }

    /**
     * Get item URL
     *
     * @return string
     */
    public function getURL()
    {
        return !Core\Auth::getInstance()->isVendor() || $this->isOfCurrentVendor() ? parent::getURL() : false;
    }

    /**
     * Wrapper. If the product was deleted,
     * item will use save product name and SKU
     *
     * @return \XLite\Model\Product
     */
    public function getProduct()
    {
        if ($this->isDeleted() && $this->getOriginalProduct()) {
            return $this->getOriginalProduct();
        }

        return parent::getProduct();
    }

    /**
     * Save item state
     *
     * @param \XLite\Model\Base\IOrderItem $item Item object
     *
     * @return void
     */
    protected function saveItemState(\XLite\Model\Base\IOrderItem $item)
    {
        parent::saveItemState($item);

        $this->setVendor($item->getVendor());
    }

    /**
     * Reset item state
     *
     * @return void
     */
    protected function resetItemState()
    {
        parent::resetItemState();

        $this->setVendor(null);
    }

    /**
     * Set vendor
     *
     * @param \XLite\Model\Profile $vendor
     * @return OrderItem
     */
    public function setVendor(\XLite\Model\Profile $vendor = null)
    {
        $this->vendor = $vendor;
        return $this;
    }

    /**
     * Get vendor
     *
     * @return \XLite\Model\Profile 
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Set originalProduct
     *
     * @param \XLite\Model\Product $originalProduct
     * @return OrderItem
     */
    public function setOriginalProduct(\XLite\Model\Product $originalProduct = null)
    {
        $this->originalProduct = $originalProduct;
        return $this;
    }

    /**
     * Get originalProduct
     *
     * @return \XLite\Model\Product 
     */
    public function getOriginalProduct()
    {
        return $this->originalProduct;
    }
}
