<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Customer;

use XLite\Core;

/**
 * Product
 */
class Product extends \XLite\Controller\Customer\Product implements \XLite\Base\IDecorator
{
    /**
     * Check it is preview or not
     *
     * @return boolean
     */
    public function isPreview()
    {
        $product = $this->getProduct();
        $previewAction = 'preview' === Core\Request::getInstance()->action;

        return parent::isPreview() || ($previewAction && $product && $product->isOfCurrentVendor());
    }
}
