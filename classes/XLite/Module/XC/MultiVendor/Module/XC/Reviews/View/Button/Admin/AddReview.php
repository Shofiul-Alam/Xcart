<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\Reviews\View\Button\Admin;

/**
 * Reviews items list widget extension
 * 
 * @Decorator\Depend ("XC\Reviews")
 */
class AddReview extends \XLite\Module\XC\Reviews\View\Button\Admin\AddReview implements \XLite\Base\IDecorator
{
        /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible()
            && \XLite\Module\XC\MultiVendor\Main::isReviewsChangeAllowedForCurrentUser();
    }
}
