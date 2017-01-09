<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Menu\Admin;

use XLite\Core\Auth;
use XLite\Module\XC\MultiVendor;

/**
 * Left menu
 */
class LeftMenu extends \XLite\View\Menu\Admin\LeftMenu implements \XLite\Base\IDecorator
{
    /**
     * Define and set handler attributes; initialize handler
     *
     * @param array $params Handler params OPTIONAL
     */
    public function __construct(array $params = array())
    {
        parent::__construct($params);

        $this->relatedTargets['profile_list'][] = 'vendor';
        $this->relatedTargets['profile_list'][] = 'financialInfo';
        $this->relatedTargets['profile_list'][] = 'vendor_products';
    }
    /**
     * Define quick links
     *
     * @return array
     */
    protected function defineQuickLinks()
    {
        $items = parent::defineQuickLinks();

        if (Auth::getInstance()->isVendor()) {
            unset(
                $items['marketplace'][static::ITEM_WIDGET]
            );

            $addNewChildren = &$items['add_new'][static::ITEM_CHILDREN];
            $this->addItemPermission($addNewChildren['add_product'], '[vendor] manage catalog');

            $this->addItemPermission($items['info'], '[vendor] manage catalog');
        }

        return $items;
    }

    /**
     * Define items
     *
     * @return array
     */
    protected function defineItems()
    {
        $items = parent::defineItems();

        if (Auth::getInstance()->isVendor()) {
            $catalogChildren = &$items['catalog'][static::ITEM_CHILDREN];

            $this->addItemPermission($catalogChildren['product_list'], '[vendor] manage catalog');
            $this->addItemPermission($catalogChildren['import'], '[vendor] manage catalog');
            $this->addItemPermission($catalogChildren['export'], '[vendor] manage catalog');
            $this->addItemPermission($catalogChildren['product_classes'], '[vendor] manage catalog');

            if (isset($catalogChildren['clone_products'])) {
                $this->addItemPermission($catalogChildren['clone_products'], '[vendor] manage catalog');
            }

            $salesChildren = &$items['sales'][static::ITEM_CHILDREN];

            $this->addItemPermission($salesChildren['order_list'], '[vendor] manage orders');
            $this->addItemPermission($salesChildren['orders_stats'], '[vendor] manage orders');

            if (!MultiVendor\Main::isWarehouseMode()) {
                $this->addItemPermission(
                    $items['store_setup'][static::ITEM_CHILDREN]['shipping_methods'],
                    '[vendor] manage shipping'
                );
                $this->addItemPermission(
                    $items['store_setup'][static::ITEM_CHILDREN]['store_info'],
                    '[vendor] manage shipping'
                );
                $items['store_setup'][static::ITEM_CHILDREN]['store_info'][static::ITEM_TITLE]
                    = static::t('Store address');
            }
        }

        $items['sales'][static::ITEM_CHILDREN]['profile_transactions_stats'] = array(
            static::ITEM_TITLE  => static::t('Vendor statistics'),
            static::ITEM_TARGET => 'profile_transactions_stats',
            static::ITEM_WEIGHT => 400,
        );
        $items['sales'][static::ITEM_CHILDREN]['profile_transactions'] = array(
            static::ITEM_TITLE  => static::t('Vendor transactions'),
            static::ITEM_TARGET => 'profile_transactions',
            static::ITEM_WEIGHT => 500,
        );

        $this->addItemPermission($items['sales'][static::ITEM_CHILDREN]['profile_transactions'], '[vendor] manage orders');
        $this->addItemPermission($items['sales'][static::ITEM_CHILDREN]['profile_transactions'], 'manage orders');

        return $items;
    }
}
