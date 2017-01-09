<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Logic\Import\Step;

use XLite\Module\XC\MultiVendor;

/**
 * Abstract import step
 */
abstract class AStep extends \XLite\Logic\Import\Step\AStep implements \XLite\Base\IDecorator
{
    /**
     * Get exportTickDuration TmpVar name
     *
     * @return string
     */
    protected function getImportTickDurationVarName()
    {
        return MultiVendor\Logic\Vendors::getVendorPrefixedName(parent::getImportTickDurationVarName());
    }
}
