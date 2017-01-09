<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\Reviews\Controller\Customer;

/**
 * Review modify controller
 *
 * @Decorator\Depend ("XC\Reviews")
 */
abstract class ACustomer extends \XLite\Controller\Customer\ACustomer implements \XLite\Base\IDecorator
{
    /**
     * Return TRUE if customer can add review for product
     *
     * @return boolean
     */
    public function isAllowedAddReview()
    {
        $result = parent::isAllowedAddReview();

        if (!\XLite\Module\XC\MultiVendor\Main::isReviewsChangeAllowedForCurrentUser()
            && $this->getProduct()
            && $this->getProduct()->isOfCurrentVendor()
        ) {
            $result = false;
        }

        return $result;
    }
}
