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
class Reviews extends \XLite\Module\XC\Reviews\Controller\Admin\Reviews implements \XLite\Base\IDecorator
{
    /**
     * Get conditions to search reviews for reset 'isNew' status
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getResetIsNewSearchCondition()
    {
        $cnd = parent::getResetIsNewSearchCondition();

        if (\XLite\Core\Auth::getInstance()->isVendor()) {
            $cnd->{\XLite\Module\XC\Reviews\Model\Repo\Review::SEARCH_VENDOR_ID} = \XLite\Core\Auth::getInstance()->getVendorId();

        } else {
            $cnd->{\XLite\Module\XC\Reviews\Model\Repo\Review::SEARCH_VENDOR_ID} = \XLite\Model\Repo\Profile::ADMIN_VENDOR_FAKE_ID;
        }

        return $cnd;
    }

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

    /**
     * Do action 'approve'
     *
     * @return void
     */
    protected function doActionApprove()
    {
        if (\XLite\Module\XC\MultiVendor\Main::isReviewsChangeAllowedForCurrentUser()) {
            parent::doActionApprove();
        }
    }

    /**
     * Do action 'approve'
     *
     * @return void
     */
    protected function doActionUnapprove()
    {
        if (\XLite\Module\XC\MultiVendor\Main::isReviewsChangeAllowedForCurrentUser()) {
            parent::doActionUnapprove();
        }
    }
}
