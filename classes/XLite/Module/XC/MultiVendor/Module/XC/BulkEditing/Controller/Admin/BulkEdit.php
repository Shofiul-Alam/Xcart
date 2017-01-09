<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\BulkEditing\Controller\Admin;

/**
 * Controller BulkEdit
 * @Decorator\Depend ("XC\BulkEditing")
 */
class BulkEdit extends \XLite\Module\XC\BulkEditing\Controller\Admin\BulkEdit implements \XLite\Base\IDecorator
{
    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        return parent::checkACL() || \XLite\Core\Auth::getInstance()->isPermissionAllowed('[vendor] manage catalog');
    }
}