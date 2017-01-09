<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\PitneyBowes\Model;


/**
 * Class represents an order
 * 
 * @Decorator\Depend ("XC\PitneyBowes")
 */
class Order extends \XLite\Model\Order implements \XLite\Base\IDecorator
{
    /**
     * @return void
     */
    protected function confirmOrderApiCall()
    {
        if ($this->isChild() && $this->getVendor()) {
            $config = \XLite\Module\XC\MultiVendor\Main::getVendorConfiguration(
                $this->getVendor(),
                array('XC', 'PitneyBowes')
            );
            \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::updateConfiguration($config);
        } else {
            \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::getProcessorConfiguration(true);
        }

        parent::confirmOrderApiCall();
    }
}
