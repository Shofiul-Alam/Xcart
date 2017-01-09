<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Core;

/**
 * Vendor rating data prodiver
 */
interface IVendorRatingsProvider
{
    /**
     * Get maximum rating value
     *
     * @return integer
     */
    public function getMaxRatingValue();

    /**
     * Overall count of reviews/ratings
     *
     * @param \XLite\Model\Profile  $vendor     Vendor object
     *
     * @return integer
     */
    public function getOverallCount(\XLite\Model\Profile $vendor);

    /**
     * Overall rating of vendor
     *
     * @param \XLite\Model\Profile  $vendor     Vendor object
     *
     * @return float
     */
    public function getOverallRating(\XLite\Model\Profile $vendor);


    /**
     * Rating Data for vendor
     *
     * @param \XLite\Model\Profile  $vendor     Vendor object
     *
     * @return array
     */
    public function getData(\XLite\Model\Profile $vendor);
}
