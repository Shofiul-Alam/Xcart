<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ItemsList\Model;

use XLite\Core\Auth;

/**
 * Order tracking number items list
 */
class OrderTrackingNumber extends \XLite\View\ItemsList\Model\OrderTrackingNumber implements \XLite\Base\IDecorator
{
    /**
     * Return true if items list should be displayed in static mode (no editable widgets, no controls)
     *
     * @return boolean
     */
    protected function isStatic()
    {
        return parent::isStatic()
            || (Auth::getInstance()->isVendor()
                && (!$this->getOrder()->isOfCurrentVendor() || $this->getOrder()->isSingle())
            );
    }
}
