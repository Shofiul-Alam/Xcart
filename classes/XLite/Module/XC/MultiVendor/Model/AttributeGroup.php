<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model;

use XLite\Core\Auth;

/**
 * Attribute group
 */
class AttributeGroup extends \XLite\Model\AttributeGroup implements \XLite\Base\IDecorator
{
    /**
     * Vendor - owner of the attribute group (relation)
     *
     * @var \XLite\Model\Profile
     *
     * @ManyToOne  (targetEntity="XLite\Model\Profile")
     * @JoinColumn (name="vendor_id", referencedColumnName="profile_id", onDelete="SET NULL")
     */
    protected $vendor;

    /**
     * Check if current user is a vendor which has access to this attribute group (i.e. owns it)
     *
     * @return boolean
     */
    public function isOfCurrentVendor()
    {
        $auth = Auth::getInstance();

        return $auth->isVendor() && (!$this->isPersistent() || $auth->getVendor() == $this->getVendor());
    }

    /**
     * Set vendor
     *
     * @param \XLite\Model\Profile $vendor
     * @return AttributeGroup
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
