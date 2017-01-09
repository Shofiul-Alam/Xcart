<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Form\ItemsList\VendorProducts;

/**
 * VendorProducts search form
 */
class Search extends \XLite\View\Form\ItemsList\AItemsListSearch
{
    /**
     * Get form parameters
     *
     * @return array
     */
    protected function getFormParams()
    {
        return parent::getFormParams() + array('profile_id' => \XLite\Core\Request::getInstance()->profile_id);
    }
}