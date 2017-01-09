<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\ProductVariants\Model;

/**
 * ProductVariant model repository extension
 *
 * @Decorator\Depend ("XC\ProductVariants")
 */
class ProductVariant extends \XLite\Module\XC\ProductVariants\Model\ProductVariant implements \XLite\Base\IDecorator
{
    /**
     * Update low stock update timestamp
     *
     * @return void
     */
    protected function updateLowStockUpdateTimestamp()
    {
        parent::updateLowStockUpdateTimestamp();

        $vendor = $this->getProduct()->getVendor();
        if ($vendor) {
            $vendorTimestamps = TmpVars::getInstance()->lowStockUpdateTimestampVendor;
            $vendorTimestamps[$vendor->getProfileId()] = LC_START_TIME;
            TmpVars::getInstance()->lowStockUpdateTimestampVendor = $vendorTimestamps;
        }
    }
}
