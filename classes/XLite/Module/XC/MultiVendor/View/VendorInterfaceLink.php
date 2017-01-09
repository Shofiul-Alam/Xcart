<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View;

use XLite\Core\Auth;
use XLite\Core\Converter;
use XLite\Core\URLManager;

/**
 * Vendor info widget for a product
 */
class VendorInterfaceLink extends \XLite\View\AView
{
    /**
     * Widget parameter names
     */
    const PARAM_CAPTION = 'caption';

    /**
     * Return category Id to use
     *
     * @return integer
     */
    protected function getCaption()
    {
        return $this->getParam(static::PARAM_CAPTION);
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
            static::PARAM_CAPTION => new \XLite\Model\WidgetParam\TypeString('Link caption', ''),
        );
    }

    /**
     * Only visible when vendor is logged in
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible() && Auth::getInstance()->isVendor();
    }

    /**
     * Get vendor interface link (admin area)
     *
     * @return string
     */
    protected function getVendorInterfaceURL()
    {
        return URLManager::getShopURL(Converter::buildURL('', '', array(), \XLite::getAdminScript()));
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/XC/MultiVendor/vendor_backend_link.twig';
    }
}
