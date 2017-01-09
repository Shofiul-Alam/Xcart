<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Model\Shipping;

use XLite\Core\Auth;

/**
 * Offline shipping method view model
 */
class Offline extends \XLite\View\Model\Shipping\Offline implements \XLite\Base\IDecorator
{
    /**
     * This object will be used if another one is not passed
     *
     * @return \XLite\Model\Shipping\Method
     */
    protected function getDefaultModelObject()
    {
        $result = parent::getDefaultModelObject();
        $vendor = Auth::getInstance()->getVendor();

        if ($vendor && !$result->isPersistent()) {
            $result->setVendor($vendor);
        }

        return $result;
    }
}
