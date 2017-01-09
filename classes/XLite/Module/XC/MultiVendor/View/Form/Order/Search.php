<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Form\Order;

/**
 * Main
 */
class Search extends \XLite\View\Form\Order\Search implements \XLite\Base\IDecorator
{
    /**
     * getDefaultParams
     *
     * @return array
     */
    protected function getDefaultParams()
    {
        return parent::getDefaultParams() + array('vendorId' => $this->getCondition('vendorId'));
    }
}
