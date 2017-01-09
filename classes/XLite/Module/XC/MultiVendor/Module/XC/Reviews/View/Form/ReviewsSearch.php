<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\Reviews\View\Form;

/**
 * Reviews search form widget
 * 
 * @Decorator\Depend ("XC\Reviews")
 */
class ReviewsSearch extends \XLite\Module\XC\Reviews\View\Form\ReviewsSearch implements \XLite\Base\IDecorator
{
    /**
     * getDefaultParams
     *
     * @return array
     */
    protected function getDefaultParams()
    {
        return parent::getDefaultParams() + array('vendorId' => $this->getCondition('vendorId'));
    }
}
