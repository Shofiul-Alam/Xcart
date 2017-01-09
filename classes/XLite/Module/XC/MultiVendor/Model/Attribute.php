<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model;

use XLite\Core;

/**
 * Attribute
 */
class Attribute extends \XLite\Model\Attribute implements \XLite\Base\IDecorator
{
    /**
     * Vendor - owner of the attribute (relation)
     * Relation is established only for global attributes
     * In other cases ownership is checked from the side of owning entities (products and product classes)
     *
     * @var \XLite\Model\Profile
     *
     * @ManyToOne  (targetEntity="XLite\Model\Profile")
     * @JoinColumn (name="vendor_id", referencedColumnName="profile_id", onDelete="SET NULL")
     */
    protected $vendor;

    /**
     * Add to new product
     *
     * @param \XLite\Model\Product $product Product
     *
     * @return void
     */
    public function addToNewProduct(\XLite\Model\Product $product)
    {
        $vendorsProduct = $product->getVendor();
        $vendorsAttribute = $this->getVendor();
        $vendorsProductClass = $this->getProductClass() && $this->getProductClass()->getVendor();

        if ($vendorsProduct || (!$vendorsAttribute && !$vendorsProductClass)) {
            parent::addToNewProduct($product);
        }
    }

    /**
     * Check if current user is a vendor which has access to this attribute (i.e. owns it)
     *
     * @return boolean
     */
    public function isOfCurrentVendor()
    {
        $auth = Core\Auth::getInstance();

        $accessProductClass = $this->getProductClass() && $this->getProductClass()->isOfCurrentVendor();
        $accessProduct = $this->getProduct() && $this->getProduct()->isOfCurrentVendor();
        $accessAttribute = !$this->isPersistent() || $auth->getVendor() == $this->getVendor();

        return $auth->isVendor() && ($accessProductClass || $accessProduct || $accessAttribute);
    }

    /**
     * Create attribute option
     *
     * @param string $value Option name
     *
     * @return mixed
     */
    protected function createAttributeOption($value)
    {
        $result = null;

        if (!Core\Auth::getInstance()->isVendor()
            || 'A' === Core\Config::getInstance()->XC->MultiVendor->attributes_access_mode
            || Core\Auth::getInstance()->checkVendorAccess($this->getVendor())
        ) {
            $result = parent::createAttributeOption($value);
        }

        return $result;
    }

    /**
     * Set vendor
     *
     * @param \XLite\Model\Profile $vendor
     * @return Attribute
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
}
