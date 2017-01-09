<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\Reviews\View\ItemsList\Model;

/**
 * Reviews items list widget extension
 * 
 * @Decorator\Depend ("XC\Reviews")
 */
class ProductReview extends \XLite\Module\XC\Reviews\View\ItemsList\Model\ProductReview implements \XLite\Base\IDecorator
{
    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        $list = parent::defineColumns();

        if (!\XLite\Module\XC\MultiVendor\Main::isReviewsChangeAllowedForCurrentUser()
            && isset($list['useForMeta'])
        ) {
            unset($list['useForMeta']);
        }

        return $list;
    }
}
