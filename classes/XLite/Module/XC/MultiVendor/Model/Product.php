<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model;

use XLite\Core;

/**
 * The "product" model class
 */
class Product extends \XLite\Model\Product implements \XLite\Base\IDecorator
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
     * Clone
     *
     * @return \XLite\Model\AEntity
     */
    public function cloneEntity()
    {
        $newProduct = parent::cloneEntity();

        if (Core\Auth::getInstance()->isVendor()) {
            $newProduct->setVendor(Core\Auth::getInstance()->getVendor());
            Core\Database::getEM()->flush();
        }

        return $newProduct;
    }

    /**
     * Check if current user is a vendor which has access to this product (i.e. owns it)
     *
     * @return boolean
     */
    public function isOfCurrentVendor()
    {
        $auth = Core\Auth::getInstance();

        return $auth->isVendor() && (!$this->isPersistent() || $auth->getVendorId() === $this->getVendorId());
    }

    /**
     * Get vendor's login
     *
     * @return integer
     */
    public function getVendorLogin()
    {
        return $this->getVendor() ? $this->getVendor()->getLogin() : null;
    }

    /**
     * Get vendor profile identifier if product has one, null otherwise
     *
     * @return integer
     */
    public function getVendorId()
    {
        return $this->getVendor() ? $this->getVendor()->getProfileId() : null;
    }

    /**
     * Returns orders count
     *
     * @return integer
     */
    public function getOrdersCount()
    {
        $repo = \XLite\Core\Database::getRepo('XLite\Model\Order');

        return $repo->getCountByProduct($this);
    }

    /**
     * Update low stock update timestamp
     *
     * @return void
     */
    protected function updateLowStockUpdateTimestamp()
    {
        parent::updateLowStockUpdateTimestamp();

        $vendor = $this->getVendor();
        if ($vendor) {
            $vendorTimestamps = Core\TmpVars::getInstance()->lowStockUpdateTimestampVendor;
            $vendorTimestamps[$vendor->getProfileId()] = LC_START_TIME;
            Core\TmpVars::getInstance()->lowStockUpdateTimestampVendor = $vendorTimestamps;
        }
    }

    /**
     * Set vendor
     *
     * @param \XLite\Model\Profile $vendor
     * @return Product
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
