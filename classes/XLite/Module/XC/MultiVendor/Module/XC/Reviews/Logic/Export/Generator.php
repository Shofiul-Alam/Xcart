<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\Reviews\Logic\Export;

/**
 * Generator
 * @Decorator\Depend ("XC\Reviews")
 */
class Generator extends \XLite\Logic\Export\Generator implements \XLite\Base\IDecorator
{
    /**
     * Get allowed export types
     *
     * @return array
     */
    protected function getExportSectionsAllowedForVendor()
    {
        return array_merge(
            parent::getExportSectionsAllowedForVendor(),
            array(
                'XLite\Module\XC\Reviews\Logic\Export\Step\Reviews',
            )
        );
    }
}
