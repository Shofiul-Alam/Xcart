<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\VolumeDiscounts\View\Form\Search;

use XLite\Controller\Admin as ControllerAdmin;

/**
 * VolumeDiscount
 *
 * @Decorator\Depend ("CDev\VolumeDiscounts")
 */
class VolumeDiscount extends \XLite\View\Form\AForm
{
    /**
     * JavaScript: this value will be returned on form submit
     * NOTE - this function designed for AJAX easy switch on/off
     *
     * @return string
     */
    protected function getOnSubmitResult()
    {
        return 'true';
    }

    /**
     * getDefaultTarget
     *
     * @return string
     */
    protected function getDefaultTarget()
    {
        return 'promotions';
    }

    /**
     * getDefaultTarget
     *
     * @return string
     */
    protected function getDefaultAction()
    {
        return 'search';
    }

    /**
     * getDefaultParams
     *
     * @return array
     */
    protected function getDefaultParams()
    {
        return parent::getDefaultParams() + array(
            'page' => ControllerAdmin\Promotions::PAGE_VOLUME_DISCOUNTS,
            'vendorId' => $this->getVolumeDiscountCondition('vendorId'),
        );
    }
}
