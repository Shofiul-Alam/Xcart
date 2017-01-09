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
class Review extends \XLite\Module\XC\Reviews\View\ItemsList\Model\Review implements \XLite\Base\IDecorator
{
    /**
     * Widget param names
     */
    const PARAM_VENDOR_ID = 'vendorId';
    const PARAM_VENDOR    = 'vendor';

    /**
     * Return search parameters
     *
     * @return array
     */
    public static function getSearchParams()
    {
        return parent::getSearchParams() + array(
            \XLite\Module\XC\Reviews\Model\Repo\Review::SEARCH_VENDOR_ID => static::PARAM_VENDOR_ID,
            \XLite\Module\XC\Reviews\Model\Repo\Review::SEARCH_VENDOR    => static::PARAM_VENDOR
        );
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_VENDOR_ID => new \XLite\Model\WidgetParam\TypeInt('Vendor ID', 0),
            static::PARAM_VENDOR    => new \XLite\Model\WidgetParam\TypeString('Vendor', ''),
        );
    }

    /**
     * Return params list to use for search
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getSearchCondition()
    {
        $result = parent::getSearchCondition();

        if (isset($result->{static::PARAM_VENDOR_ID})
            && is_numeric($result->{static::PARAM_VENDOR_ID})
        ) {
            unset($result->{static::PARAM_VENDOR});

        } else {
            unset($result->{static::PARAM_VENDOR_ID});
        }

        return $result;
    }

    /**
     * Get right actions templates name
     *
     * @return array
     */
    protected function getRightActions()
    {
        return \XLite\Module\XC\MultiVendor\Main::isReviewsChangeAllowedForCurrentUser()
            ? parent::getRightActions()
            : array();
    }
}
