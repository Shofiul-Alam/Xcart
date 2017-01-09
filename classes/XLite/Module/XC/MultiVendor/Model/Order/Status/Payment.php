<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\Order\Status;

/**
 * Order payment status
 * @MappedSuperClass
 */
abstract class Payment extends \XLite\Model\Order\Status\Payment implements \XLite\Base\IDecorator
{
    /**
     * Get open order statuses
     *
     * @return array
     */
    public static function getNotPaidStatuses()
    {
        return array(
            static::STATUS_QUEUED,
            static::STATUS_REFUNDED,
            static::STATUS_DECLINED,
            static::STATUS_CANCELED,
            static::STATUS_AUTHORIZED,
        );
    }
    /**
     * Return status handlers list
     *
     * @return array
     */
    public static function getStatusHandlers()
    {
        $handlers = parent::getStatusHandlers();

        foreach (static::getNotPaidStatuses() as $status) {
            if (!isset($handlers[$status])) {
                $handlers[$status] = array(
                    static::STATUS_PAID => array()
                );
            }
            if (!isset($handlers[$status][static::STATUS_PAID])) {
                $handlers[$status][static::STATUS_PAID] = array();
            }
            array_push(
                $handlers[$status][static::STATUS_PAID],
                'createDebit'
            );
            if (!isset($handlers[static::STATUS_PAID][$status])) {
                $handlers[static::STATUS_PAID][$status] = array();
            }
            array_push(
                $handlers[static::STATUS_PAID][$status],
                'createCredit'
            );
        }

        return $handlers;
    }
}
