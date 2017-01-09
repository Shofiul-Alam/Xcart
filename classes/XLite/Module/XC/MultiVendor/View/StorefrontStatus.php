<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View;

/**
 * Storefront status
 */
class StorefrontStatus extends \XLite\View\StorefrontStatus implements \XLite\Base\IDecorator
{
    /**
     * Get accessible shop URL
     *
     * @return string
     */
    protected function getAccessibleShopURL()
    {
        $auth = \XLite\Core\Auth::getInstance();

        return $auth->isVendor()
            ? \XLite::getInstance()->getShopURL(
                \XLite\Core\Converter::buildURL('vendor', '', array('vendor_id' => $auth->getVendorId()), \XLite::getCustomerScript()),
                null,
                $auth->isClosedStorefront() ? array('shopKey' => $auth->getShopKey()) : array()
            )
            : parent::getAccessibleShopURL();
    }
}
