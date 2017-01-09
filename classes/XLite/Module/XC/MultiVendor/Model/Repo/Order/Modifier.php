<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\Repo\Order;

/**
 * Order modifier repository
 */
class Modifier extends \XLite\Model\Repo\Order\Modifier implements \XLite\Base\IDecorator
{
    /**
     * Retrieve modifiers from database
     * Clone result objects to avoid wrong calculation for several open carts
     *
     * @return \XLite\Model\Order\Modifier[]
     */
    protected function retrieveModifiers()
    {
        return array_map(function ($item) {
            return clone $item;
        }, parent::retrieveModifiers());
    }
}
