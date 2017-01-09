<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\Reviews\Controller\Admin;

/**
 * Reviews page controller extension
 * 
 * @Decorator\Depend ("XC\Reviews")
 */
class Review extends \XLite\Module\XC\Reviews\Controller\Admin\Review implements \XLite\Base\IDecorator
{
    /**
     * Update list
     *
     * @return void
     */
    protected function doActionUpdate()
    {
        if (\XLite\Module\XC\MultiVendor\Main::isReviewsChangeAllowedForCurrentUser()) {
            parent::doActionUpdate();
        }
    }

    /**
     * Create new model
     *
     * @return void
     */
    protected function doActionCreate()
    {
        if (\XLite\Module\XC\MultiVendor\Main::isReviewsChangeAllowedForCurrentUser()) {
            parent::doActionCreate();
        }
    }

    /**
     * Modify model
     *
     * @return void
     */
    protected function doActionModify()
    {
        if (\XLite\Module\XC\MultiVendor\Main::isReviewsChangeAllowedForCurrentUser()) {
            parent::doActionModify();
        }
    }

    /**
     * Do action 'delete'
     *
     * @return void
     */
    protected function doActionDelete()
    {
        if (\XLite\Module\XC\MultiVendor\Main::isReviewsChangeAllowedForCurrentUser()) {
            parent::doActionDelete();
        }
    }

}
