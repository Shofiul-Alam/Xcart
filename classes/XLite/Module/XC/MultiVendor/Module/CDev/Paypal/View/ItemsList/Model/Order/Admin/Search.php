<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\Paypal\View\ItemsList\Model\Order\Admin;

/**
 * Search order
 * 
 * @Decorator\Depend ({"CDev\Paypal", "XC\MultiVendor"})
 */
class Search extends \XLite\View\ItemsList\Model\Order\Admin\Search implements \XLite\Base\IDecorator
{
    /**
     * Get a list of CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/XC/MultiVendor/css/search.css';

        return $list;
    }

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        $columns = parent::defineColumns();

        if (isset($columns['commission'])) {
            $columns['commission'][static::COLUMN_TEMPLATE] ='modules/XC/MultiVendor/item_lists/parts/commission.twig';
        }

        return $columns;
    }
}
