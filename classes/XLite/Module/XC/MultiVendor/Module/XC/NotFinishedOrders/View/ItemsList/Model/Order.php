<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\NotFinishedOrders\View\ItemsList\Model;

use XLite\Module\XC\MultiVendor;

/**
 * Orders items list extension
 *
 * @Decorator\Depend ("XC\NotFinishedOrders")
 */
class Order extends \XLite\View\ItemsList\Model\Order\Admin\Search implements \XLite\Base\IDecorator
{
    /**
     * Get page data for update
     *
     * @return array
     */
    protected function getPageDataForUpdate()
    {
        $list = parent::getPageDataForUpdate();

        if (!MultiVendor\Main::isWarehouseMode()) {
            // In 'Vendors as separate shops' mode we shoud update only parent NFO
            foreach ($list as $i => $entity) {
                if ($entity->isNotFinishedOrder() && $entity->isChild()) {
                    $list[$i] = $entity->getParent();
                }
            }
        }

        return $list;
    }
}
