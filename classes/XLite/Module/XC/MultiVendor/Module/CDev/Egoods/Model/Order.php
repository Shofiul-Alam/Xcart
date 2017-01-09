<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\Egoods\Model;

use XLite\Module\XC\MultiVendor;

/**
 * Order
 *
 * @Decorator\Depend ("CDev\Egoods")
 */
abstract class Order extends \XLite\Model\Order implements \XLite\Base\IDecorator
{
    protected static $processingParent = false;

    /**
     * Get Pivate attachments list
     *
     * @return array
     */
    public function getPrivateAttachments()
    {
        $attachments = array();

        if (static::$processingParent === false
            || $this->isParent()
            || ($this->isChild() && !MultiVendor\Main::isWarehouseMode())
        ) {
            $attachments = parent::getPrivateAttachments();
        }

        return $attachments;
    }

    /**
     * A "change status" handler
     *
     * @return void
     */
    protected function processProcess()
    {
        if ($this->isParent()) {
            static::$processingParent = true;
        }

        parent::processProcess();

        if ($this->isParent()) {
            static::$processingParent = false;
        }
    }
}
