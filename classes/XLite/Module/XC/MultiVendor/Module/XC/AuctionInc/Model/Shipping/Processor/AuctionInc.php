<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\AuctionInc\Model\Shipping\Processor;

/**
 * Shipping processor model
 *
 * @Decorator\Depend ("XC\AuctionInc")
 */
class AuctionInc
    extends \XLite\Module\XC\AuctionInc\Model\Shipping\Processor\AuctionInc
    implements \XLite\Base\IDecorator
{
    /**
     * Generate first usage date
     *
     * @return void
     */
    protected function generateFirstUsageDate()
    {
        $vendor = $this->getVendor();

        if ($vendor) {
            \XLite\Core\Database::getRepo('XLite\Model\Config')->createOption(array(
                'category' => 'XC\AuctionInc',
                'name' => 'firstUsageDate',
                'value' => LC_START_TIME,
                'vendor' => $vendor,
            ));
        } else {
            parent::generateFirstUsageDate();
        }
    }

    /**
     * Generate first usage date
     *
     * @return string
     */
    protected function generateHeaderReferenceCode()
    {
        $vendor = $this->getVendor();

        if ($vendor) {
            $code = 'XC5-' . md5(LC_START_TIME);
            \XLite\Core\Database::getRepo('XLite\Model\Config')->createOption(array(
                'category' => 'XC\AuctionInc',
                'name' => 'headerReferenceCode',
                'value' => $code,
                'vendor' => $vendor,
            ));
        } else {
            $code = parent::generateHeaderReferenceCode();
        }

        return $code;
    }
}
