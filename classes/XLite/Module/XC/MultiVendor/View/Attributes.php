<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View;

/**
 * Attributes page view
 */
class Attributes extends \XLite\View\Attributes implements \XLite\Base\IDecorator
{
    /**
     * Return true if top buttons should be visible
     *
     * @return boolean
     */
    protected function isButtonsBlockVisible()
    {
        $result = parent::isButtonsBlockVisible();

        if ($result) {
            $productClass = $this->getProductClass();
            $result = \XLite\Core\Auth::getInstance()->isPermissionAllowed(\XLite\Model\Role\Permission::ROOT_ACCESS)
                || ($productClass && \XLite\Core\Auth::getInstance()->checkVendorAccess($productClass->getVendor()));
        }

        return $result;
    }
}
