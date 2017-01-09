<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model;

/**
 * DB-based configuration registry
 */
class Config extends \XLite\Model\Config implements \XLite\Base\IDecorator
{
    /**
     * Vendor
     *
     * @var \XLite\Model\Profile
     *
     * @ManyToOne  (targetEntity="XLite\Model\Profile")
     * @JoinColumn (name="vendor_id", referencedColumnName="profile_id", onDelete="cascade")
     */
    protected $vendor;

    /**
     * Set vendor
     *
     * @param \XLite\Model\Profile|integer $value Vendor
     *
     * @return void
     */
    public function setVendor($value)
    {
        if (!($value instanceof \XLite\Model\Profile)) {
            $vendor = \XLite\Core\Database::getRepo('XLite\Model\Profile')->find($value);

            $value = $vendor && $vendor->isVendor() ? $vendor : null;
        }

        $this->vendor = $value;
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
