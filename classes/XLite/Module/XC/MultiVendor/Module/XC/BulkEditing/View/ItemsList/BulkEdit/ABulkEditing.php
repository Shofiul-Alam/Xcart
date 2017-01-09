<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\BulkEditing\View\ItemsList\BulkEdit;

/**
 * Abstract product list
 * @Decorator\Depend ("XC\BulkEditing")
 */
abstract class ABulkEditing extends \XLite\Module\XC\BulkEditing\View\ItemsList\BulkEdit\ABulkEditing implements \XLite\Base\IDecorator
{
    /**
     * Return modules list
     *
     * @param \XLite\Core\CommonCell $cnd       Search condition
     * @param boolean                $countOnly Return items list or only its size OPTIONAL
     *
     * @return array|integer
     */
    protected function getData(\XLite\Core\CommonCell $cnd, $countOnly = false)
    {
        $repo = \XLite\Core\Database::getRepo($this->defineRepositoryName());

        if (method_exists($repo, 'disableVendorCondition')) {
            $repo->disableVendorCondition();
        }

        return $repo->search($cnd, $countOnly);
    }
}