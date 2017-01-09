<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Admin;

/**
 * Orders statistics page controller
 */
abstract class OriginAddress extends \XLite\Controller\Admin\OriginAddress implements \XLite\Base\IDecorator
{

    /**
     * Check if accessinble for vendor
     */
    protected function checkVendorAccess()
    {
        return !\XLite\Module\XC\MultiVendor\Main::isWarehouseMode()
            && \XLite\Core\Auth::getInstance()->isPermissionAllowed('[vendor] manage shipping')
            && $this instanceof \XLite\Controller\Admin\OriginAddress;
    }

    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        return parent::checkACL() || $this->checkVendorAccess();
    }

    /**
     * Check if current page is accessible
     *
     * @return boolean
     */
    public function checkAccess()
    {
        return parent::checkAccess() || $this->checkVendorAccess();
    }
}
