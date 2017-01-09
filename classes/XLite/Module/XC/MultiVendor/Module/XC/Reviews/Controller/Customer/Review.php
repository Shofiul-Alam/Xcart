<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\Reviews\Controller\Customer;

use XLite\Core\Database;
use XLite\Core\TmpVars;

/**
 * Review modify controller
 *
 * @Decorator\Depend ("XC\Reviews")
 */
class Review extends \XLite\Module\XC\Reviews\Controller\Customer\Review implements \XLite\Base\IDecorator
{
    /**
     * Update reviews update timestamp
     *
     * @return void
     */
    protected function updateNewReviewsUpdateTimestamp()
    {
        parent::updateNewReviewsUpdateTimestamp();

        $product = Database::getRepo('XLite\Model\Product')->find($this->getProductId());
        $vendor = $product->getVendor();
        if ($vendor) {
            $vendorTimestamps = TmpVars::getInstance()->newReviewsUpdateTimestampVendor;
            $vendorTimestamps[$vendor->getProfileId()] = LC_START_TIME;
            TmpVars::getInstance()->newReviewsUpdateTimestampVendor = $vendorTimestamps;
        }
    }

    /**
     * Is allowed to change by the currect user
     *
     * @return boolean
     */
    protected function isAllowedForCurrentUser()
    {
        return \XLite\Module\XC\MultiVendor\Main::isReviewsChangeAllowedForCurrentUser()
            || !$this->getProduct()->isOfCurrentVendor();
    }

    /**
     * Update list
     *
     * @return void
     */
    protected function doActionUpdate()
    {
        if ($this->isAllowedForCurrentUser()) {
            parent::doActionUpdate();
        }
    }

    /**
     * Create new model
     *
     * @return void
     */
    protected function doActionCreate()
    {
        if ($this->isAllowedForCurrentUser()) {
            parent::doActionCreate();
        }
    }

    /**
     * Modify model
     *
     * @return void
     */
    protected function doActionModify()
    {
        if ($this->isAllowedForCurrentUser()) {
            parent::doActionModify();
        }
    }
}
