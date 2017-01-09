<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Form\Order;

/**
 * Currency selector form
 */
class CurrencySelector extends \XLite\View\Form\Order\CurrencySelector implements \XLite\Base\IDecorator
{
    /**
     * Returns JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'modules/XC/MultiVendor/vendor_selector.js';

        return $list;
    }

    /**
     * getDefaultParams
     *
     * @return array
     */
    protected function getDefaultParams()
    {
        return parent::getDefaultParams() + array('vendorId' => \XLite\Core\Request::getInstance()->vendorId ?: 0);
    }
}
