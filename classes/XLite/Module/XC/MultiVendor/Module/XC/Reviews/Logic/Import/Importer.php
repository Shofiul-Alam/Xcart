<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\Reviews\Logic\Import;

/**
 * Importer
 *
 * @Decorator\Depend ("XC\Reviews")
 */
class Importer extends \XLite\Logic\Import\Importer implements \XLite\Base\IDecorator
{
    /**
     * Get processor list
     *
     * @return array
     */
    public static function getProcessorList()
    {
        $processors = parent::getProcessorList();

        if (!\XLite\Module\XC\MultiVendor\Main::isReviewsChangeAllowedForCurrentUser()) {
            $reviewsProcessor = array_search('XLite\Module\XC\Reviews\Logic\Import\Processor\Reviews', $processors, true);
            if ($reviewsProcessor !== false) {
                unset($processors[$reviewsProcessor]);
            }
        }

        return $processors;
    }
}
