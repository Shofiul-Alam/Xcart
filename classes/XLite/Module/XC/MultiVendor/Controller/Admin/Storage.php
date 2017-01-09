<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Admin;

use XLite\Module\CDev\FileAttachments;

/**
 * Storage
 *
 * @Decorator\Depend("CDev\FileAttachments")
 */
abstract class Storage extends \XLite\Controller\Admin\Storage implements \XLite\Base\IDecorator
{
    /**
     * Check if current page is accessible
     *
     * @return boolean
     */
    public function checkAccess()
    {
        return parent::checkAccess()
            && $this->getStorage() instanceof FileAttachments\Model\Product\Attachment\Storage
            && ($this->getStorage()->getAttachment()->getProduct()->isOfCurrentVendor()
                || \XLite\Core\Auth::getInstance()->isPermissionAllowed(\XLite\Model\Role\Permission::ROOT_ACCESS)
                || \XLite\Core\Auth::getInstance()->isPermissionAllowed('manage catalog'));
    }
}
