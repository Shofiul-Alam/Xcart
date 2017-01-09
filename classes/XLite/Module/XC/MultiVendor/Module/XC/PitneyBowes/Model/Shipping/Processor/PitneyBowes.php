<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\PitneyBowes\Model\Shipping\Processor;

/**
 * Shipping processor model
 * @Decorator\Depend ("XC\PitneyBowes")
 */
class PitneyBowes extends \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes implements \XLite\Base\IDecorator
{
    /**
     * Set vendor
     *
     * @param \XLite\Model\Profile $vendor Vendor
     *
     * @return void
     */
    public function setVendor($vendor)
    {
        parent::setVendor($vendor);

        static::updateConfiguration($this->getConfiguration());
    }
}
