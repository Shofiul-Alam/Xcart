<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\Order;

/**
 * Surcharge
 */
class Surcharge extends \XLite\Model\Order\Surcharge implements \XLite\Base\IDecorator
{
    /**
     * Surcharge owner (order)
     *
     * @var \XLite\Model\Profile
     *
     * @ManyToOne  (targetEntity="XLite\Model\Profile")
     * @JoinColumn (name="vendor_id", referencedColumnName="profile_id", onDelete="SET NULL")
     *
     * @deprecated
     */
    protected $vendor;

    /**
     * Set vendor
     *
     * @param \XLite\Model\Profile $vendor
     * @return Surcharge
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
