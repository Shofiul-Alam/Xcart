<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\Shipping;

use XLite\Core\Auth;

/**
 * Shipping method model
 */
class Method extends \XLite\Model\Shipping\Method implements \XLite\Base\IDecorator
{
    /**
     * Vendor profile
     *
     * @var \XLite\Model\Profile
     *
     * @ManyToOne (targetEntity="XLite\Model\Profile")
     * @JoinColumn (name="vendor_id", referencedColumnName="profile_id", onDelete="SET NULL")
     */
    protected $vendor;

    /**
     * Check if current user is a vendor which has access to this product (i.e. owns it)
     *
     * @return boolean
     */
    public function isOfCurrentVendor()
    {
        $vendor = Auth::getInstance()->getVendor();

        return $vendor
            && (!$this->isPersistent()
                || ($this->getVendor() && $vendor->getVendorId() === $this->getVendor()->getVendorId())
            );
    }

    /**
     * Set vendor
     *
     * @param \XLite\Model\Profile $vendor Vendor
     *
     * @return void
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor ?: null;
    }

    /**
     * Retuns children methods for online carrier
     *
     * @return array
     */
    public function getChildrenMethods()
    {
        $vendor = $this->getVendor();

        if ($vendor) {
            $result = 'offline' !== $this->getProcessor() && '' === $this->getCarrier()
                ? $this->getRepository()->findMethodsByProcessorAndVendor($this->getProcessor(), $vendor, false)
                : array();

        } else {
            $result = parent::getChildrenMethods();
        }

        return $result;
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
