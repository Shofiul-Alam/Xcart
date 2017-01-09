<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\PitneyBowes\Core\Task;

/**
 * Scheduled task that sends automatic cart reminders.
 * @Decorator\Depend ("XC\PitneyBowes")
 */
class PitneyBowesCatalog extends \XLite\Module\XC\PitneyBowes\Core\Task\PitneyBowesCatalog implements \XLite\Base\IDecorator
{
    /**
     * Returns configuration
     * 
     * @return \XLite\Core\ConfigCell
     */
    protected function getConfiguration()
    {
        if (\XLite\Core\Auth::getInstance()->isVendor()) {
            $config = \XLite\Module\XC\MultiVendor\Main::getVendorConfiguration(
                \XLite\Core\Auth::getInstance()->getProfile(),
                array('XC', 'PitneyBowes')
            );
            \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::updateConfiguration($config);
        }

        return parent::getConfiguration();
    }
}