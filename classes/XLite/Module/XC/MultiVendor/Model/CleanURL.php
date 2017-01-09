<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model;

/**
 * CleanURL
 */
class CleanURL extends \XLite\Model\CleanURL implements \XLite\Base\IDecorator
{
    /**
     * Relation to a product entity
     *
     * @var \XLite\Module\XC\News\Model\NewsMessage
     *
     * @ManyToOne  (targetEntity="XLite\Model\Profile", inversedBy="cleanURLs")
     * @JoinColumn (name="vendor_id", referencedColumnName="profile_id")
     */
    protected $vendor;

    /**
     * Set vendor
     *
     * @param \XLite\Model\Profile $vendor
     * @return CleanURL
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
