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
class ReviewsVendorRating implements \XLite\Module\XC\MultiVendor\Core\IVendorRatingsProvider
{
    /**
     * @var array Vendor reviews runtime cache
     */
    protected $vendorReviews;

    /**
     * Rating Data for vendor
     *
     * @param \XLite\Model\Profile  $vendor     Vendor object
     *
     * @return array
     */
    public function getData(\XLite\Model\Profile $vendor)
    {
        $result = array();

        $rating = $this->getRatingsAggregated(
            array_map(
                function($review) {
                    return $review->getRating();
                },
                $this->getVendorReviews($vendor)
            )
        );

        $allCount = $this->getOverallCount($vendor);
        $result = array_map(
            function($rating) use ($allCount) {
                $rating['percent'] = ceil(100 * $rating['count'] / $allCount);

                return $rating;
            },
            $rating
        );

        return $result;
    }

    /**
     * Overall count of reviews/ratings
     *
     * @param \XLite\Model\Profile  $vendor     Vendor object
     *
     * @return integer
     */
    public function getOverallCount(\XLite\Model\Profile $vendor)
    {
        return count($this->getVendorReviews($vendor));
    }

    /**
     * Overall rating of vendor
     *
     * @param \XLite\Model\Profile  $vendor     Vendor object
     *
     * @return float
     */
    public function getOverallRating(\XLite\Model\Profile $vendor)
    {
        $cnd = $this->getSearchConditions($vendor->getProfileId());

        return \XLite\Core\Database::getRepo('\XLite\Module\XC\Reviews\Model\Review')
            ->searchAverageRating($cnd);
    }

    /**
     * Get maximum rating value
     *
     * @return integer
     */
    public function getMaxRatingValue()
    {
        return 5;
    }

    /**
     * Get ratings prepared for view
     *
     * @return array
     */
    protected function getRatingsAggregated($ratingsRaw)
    {
        $ranks = range(5, 1);
        $ratingsBlank = array_fill_keys($ranks, array('count' => 0));

        return array_reduce(
            $ratingsRaw,
            function($carry, $rank) {
                $carry[$rank]['count']++;

                return $carry;
            },
            $ratingsBlank
        );
    }

    /**
     * Get vendor reviews
     *
     * @param \XLite\Model\Profile  $vendor     Vendor object
     *
     * @return array
     */
    protected function getVendorReviews(\XLite\Model\Profile $vendor)
    {
        if($this->vendorReviews === null) {
            $cnd = $this->getSearchConditions($vendor->getProfileId());

            $this->vendorReviews = \XLite\Core\Database::getRepo('\XLite\Module\XC\Reviews\Model\Review')
                ->search($cnd);
        }

        return $this->vendorReviews;
    }

    /**
     * Get search conditions
     *
     * @param integer $vendorId Vendor id
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getSearchConditions($vendorId)
    {
        $cnd = new \XLite\Core\CommonCell();
        $cnd->vendorId  = $vendorId;
        $cnd->status    = \XLite\Module\XC\Reviews\Model\Review::STATUS_APPROVED;

        return $cnd;
    }
}
