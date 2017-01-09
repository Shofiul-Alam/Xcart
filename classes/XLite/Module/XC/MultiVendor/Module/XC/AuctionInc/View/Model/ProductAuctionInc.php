<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\AuctionInc\View\Model;

/**
 * Product AuctionInc related data model
 *
 * @Decorator\Depend ("XC\AuctionInc")
 */
class ProductAuctionInc
    extends \XLite\Module\XC\AuctionInc\View\Model\ProductAuctionInc
    implements \XLite\Base\IDecorator
{
    /**
     * Check if SS available
     *
     * @return boolean
     */
    protected function isSSAvailable()
    {
        $vendor = $this->getProduct() ? $this->getProduct()->getVendor() : null;

        if ($vendor) {
            $config = \XLite\Module\XC\MultiVendor\Main::getVendorConfiguration($vendor, array('XC', 'AuctionInc'));

            return (bool) $config->accountId;

        } else {
            return parent::isSSAvailable();
        }
    }
}
