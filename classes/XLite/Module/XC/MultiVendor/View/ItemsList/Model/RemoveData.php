<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ItemsList\Model;

/**
 * Attributes items list
 */
class RemoveData extends \XLite\View\ItemsList\Model\RemoveData implements \XLite\Base\IDecorator
{
    /**
     * Remove orders
     *
     * @return integer
     */
    protected function removeOrders()
    {
        $repo = \XLite\Core\Database::getRepo('XLite\Model\Order');

        $i = 1;
        $count = 0;
        foreach ($repo->iterateAllValidOrdersForRemove() as $data) {
            $repo->delete($data[0], false);
            $count++;
            $i++;

            if ($count >= static::LIMIT) {
                \XLite\Core\Database::getEM()->flush();
                $count = 0;
            }
        }

        \XLite\Core\Database::getEM()->flush();

        return $i + parent::removeOrders();
    }
}
