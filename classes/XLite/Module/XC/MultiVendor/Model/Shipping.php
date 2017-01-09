<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model;

/**
 * Common shipping method
 */
class Shipping extends \XLite\Model\Shipping implements \XLite\Base\IDecorator
{
    /**
     * Check if processor is enabled
     *
     * @param \XLite\Model\Shipping\Processor\AProcessor $processor Processor
     * @param \XLite\Logic\Order\Modifier\Shipping       $modifier  Modifier
     *
     * @return array
     */
    protected function isProcessorEnabled($processor, $modifier)
    {
        $vendor = $modifier->getOrder()->getVendor();
        $processor->setVendor($vendor);

        return parent::isProcessorEnabled($processor, $modifier);
    }

    /**
     * Get rates from processor
     *
     * @param \XLite\Model\Shipping\Processor\AProcessor $processor Processor
     * @param \XLite\Logic\Order\Modifier\Shipping       $modifier  Modifier
     *
     * @return array
     */
    protected function getProcessorRates($processor, $modifier)
    {
        $vendor = $modifier->getOrder()->getVendor();
        $processor->setVendor($vendor);

        return parent::getProcessorRates($processor, $modifier);
    }
}
