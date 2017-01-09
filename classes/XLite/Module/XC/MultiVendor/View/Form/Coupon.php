<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Form;

/**
 * Coupon
 *
 * @Decorator\Depend ("CDev\Coupons")
 */
class Coupon extends \XLite\Module\CDev\Coupons\View\Form\Coupon implements \XLite\Base\IDecorator
{
    /**
     * getDefaultParams
     *
     * @return array
     */
    protected function getDefaultParams()
    {
        $result = parent::getDefaultParams();

        $vendorId = '';
        if ($this->getCurrentForm()
            && $this->getCurrentForm()->getModelObject()
            && $this->getCurrentForm()->getModelObject()->getVendor()
        ) {
            $vendorId = $this->getCurrentForm()->getModelObject()->getVendor()->getProfileId();
        }

        $result['vendorId'] = $vendorId;

        return $result;
    }
}
