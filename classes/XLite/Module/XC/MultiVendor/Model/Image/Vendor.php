<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\Image;

/**
 * Vendor image (logo)
 *
 * @Entity
 * @Table  (name="vendor_images")
 */
class Vendor extends \XLite\Model\Base\Image
{
    /**
     * Relation to a vendor profile entity
     *
     * @var \XLite\Model\Profile
     *
     * @OneToOne   (targetEntity="XLite\Model\Profile", inversedBy="vendorImage")
     * @JoinColumn (name="vendor_id", referencedColumnName="profile_id")
     */
    protected $vendor;

    /**
     * Alternative image text
     *
     * @var string
     *
     * @Column (type="string", length=255)
     */
    protected $alt = '';

    /**
     * Set alt
     *
     * @param string $alt
     * @return Vendor
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set vendor
     *
     * @param \XLite\Model\Profile $vendor
     * @return Vendor
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
