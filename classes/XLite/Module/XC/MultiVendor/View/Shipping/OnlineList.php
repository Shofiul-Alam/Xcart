<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Shipping;

use XLite\Core;
use XLite\Module\XC\MultiVendor;

/**
 * Online shipping carriers list
 */
class OnlineList extends \XLite\View\Shipping\OnlineList implements \XLite\Base\IDecorator
{
    /**
     * Returns online shipping methods (carriers)
     *
     * @return \XLite\Model\Shipping\Method[]
     */
    protected function getMethods()
    {
        /** @var \XLite\Model\Repo\Shipping\Method $repo */
        $repo = Core\Database::getRepo('XLite\Model\Shipping\Method');
        $result = $repo->findOnlineCarriersByVendor(null);

        return Core\Auth::getInstance()->isVendor()
            ? array_filter($result, function ($item) {
                /** @var \XLite\Model\Shipping\Method $item */
                $module = $item->getProcessorModule();

                return $module && $module->isInstalled() && $module->getEnabled();
            })
            : $result;
    }
}
