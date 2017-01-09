<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\NotFinishedOrders\View\ItemsList\Model\Payment;

use XLite\Module\XC\MultiVendor;

/**
 * Orders items list extension
 *
 * @Decorator\Rely ("XC\NotFinishedOrders")
 * @Decorator\Before ("XC\NotFinishedOrders")
 */
class Transaction extends \XLite\View\ItemsList\Model\Payment\Transaction implements \XLite\Base\IDecorator
{
    /**
     * Return orders for 'order' column
     *
     * @param @param \XLite\Model\Payment\Transaction $entity Entity
     *
     * @return array
     */
    protected function getOrders($entity)
    {
        $nfo = $this->getLinkedOrder($entity);

        return $nfo ? array($nfo) : parent::getOrders($entity);
    }
}
