<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\Reviews\View\StickyPanel\ItemsList;

/**
 * Reviews items list's sticky panel
 */
class Review extends \XLite\Module\XC\Reviews\View\StickyPanel\ItemsList\Review implements \XLite\Base\IDecorator
{
    /**
     * Define additional buttons
     *
     * @return array
     */
    protected function defineAdditionalButtons()
    {
        $list = parent::defineAdditionalButtons();
        if (!\XLite\Module\XC\MultiVendor\Main::isReviewsChangeAllowedForCurrentUser()) {
            unset($list['state'], $list['delete']);
        }

        return $list;
    }
}
