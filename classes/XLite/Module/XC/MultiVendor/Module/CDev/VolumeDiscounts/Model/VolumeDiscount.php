<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\VolumeDiscounts\Model;

use XLite\Core;
use XLite\Model;

/**
 * Volume discount
 *
 * @Decorator\Depend ("CDev\VolumeDiscounts")
 */
class VolumeDiscount extends \XLite\Module\CDev\VolumeDiscounts\Model\VolumeDiscount implements \XLite\Base\IDecorator
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
     * Check if current vendor has access to this order
     *
     * @return boolean
     */
    public function isOfCurrentVendor()
    {
        $auth = Core\Auth::getInstance();

        return $auth->isVendor()
            && $this->getVendor()
            && $this->getVendor()->getProfileId() === $auth->getVendorId();
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
}
