<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\Shofi\ToolListing\View\Form\Modify;

/**
 * Inventory
 */
class ShippingMarketing extends \XLite\View\Form\Product\Modify\Base\Single
{
    /**
     * getDefaultAction
     *
     * @return string
     */
    protected function getDefaultAction()
    {
        xdebug_break();
        return 'update_shipping_marketing';
    }
}
