<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\Reviews\View\Menu\Admin;

use XLite\Core\Auth;
use XLite\Core\TmpVars;

/**
 * 'New product reviews' info panel notification class
 *
 * @Decorator\Depend ("XC\Reviews")
 */
class NewReviews extends \XLite\Module\XC\Reviews\View\Menu\Admin\NewReviews implements \XLite\Base\IDecorator
{
    /**
     * Returns last update timestamp
     *
     * @return integer
     */
    protected function getLastUpdateTimestamp()
    {
        $vendor = Auth::getInstance()->getVendor();

        return $vendor ? $this->getLastUpdateTimestampVendor($vendor) : parent::getLastUpdateTimestamp();
    }

    /**
     * Returns last update timestamp for vendor
     *
     * @param \XLite\Model\Profile $vendor Vendor
     *
     * @return integer
     */
    protected function getLastUpdateTimestampVendor($vendor)
    {
        $vendorTimestamps = TmpVars::getInstance()->newReviewsUpdateTimestampVendor;

        if (!isset($vendorTimestamps[$vendor->getProfileId()])) {
            $result = LC_START_TIME;
            $vendorTimestamps[$vendor->getProfileId()] = $result;
            TmpVars::getInstance()->newReviewsUpdateTimestampVendor = $vendorTimestamps;
        }

        return $vendorTimestamps[$vendor->getProfileId()];
    }

    /**
     * Get parameters to search product reviews
     *
     * @return \Doctrine\ORM\PersistentCollection|integer
     */
    protected function getReviewsSearchParams()
    {
        $cnd = parent::getReviewsSearchParams();

        if (!\XLite\Core\Auth::getInstance()->isVendor()) {
            $cnd->{\XLite\Module\XC\Reviews\Model\Repo\Review::SEARCH_VENDOR_LOGIN} = 0;
        }

        return $cnd;
    }
}
