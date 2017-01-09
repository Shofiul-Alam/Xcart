<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Admin;

use XLite\Core\Auth;

/**
 * Select file controller
 *
 * @Decorator\Depend("CDev\FileAttachments")
 */
abstract class SelectFile extends \XLite\Controller\Admin\SelectFile implements \XLite\Base\IDecorator
{
    /**
     * "Local file" handler for product images.
     *
     * @return void
     */
    protected function doActionSelectLocalProductAttachments()
    {
        if (!Auth::getInstance()->isVendor()) {
            parent::doActionSelectLocalProductAttachments();
        }
    }
}
