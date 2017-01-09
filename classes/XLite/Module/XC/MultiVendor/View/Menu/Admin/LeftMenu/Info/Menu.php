<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Menu\Admin\LeftMenu\Info;

use XLite\Core\Auth;
use XLite\Core\TmpVars;

/**
 * Left side menu widget
 */
class Menu extends \XLite\View\Menu\Admin\LeftMenu\Info\Menu implements \XLite\Base\IDecorator
{
    /**
     * Define menu items
     *
     * @return array
     */
    protected function defineItems()
    {
        $items = parent::defineItems();
        $items['unapprovedVendor'] = array(
                static::ITEM_WEIGHT     => 400,
                static::ITEM_WIDGET     => 'XLite\Module\XC\MultiVendor\View\Menu\Admin\LeftMenu\Info\UnapprovedVendor',
            );

        return $items;
    }

    /**
     * Prepare items
     *
     * @param array $items Items
     *
     * @return array
     */
    protected function prepareItems($items)
    {
        $allowedKeys = $this->getAllowedInfoItems();

        foreach ($items as $key => $data) {
            if (!in_array($key, $allowedKeys, true)) {
                unset($items[$key]);
            }
        }

        return parent::prepareItems($items);
    }

    /**
     * Get list of item keys allowed to display under 'Info' menu
     *
     * @return array
     */
    protected function getAllowedInfoItems()
    {
        return array(
            'lowStock',
            'newReviews',
        );
    }

    /**
     * Returns last read timestamp
     *
     * @return integer
     */
    protected function getLastReadTimestamp()
    {
        $vendor = Auth::getInstance()->getVendor();

        return $vendor ? $this->getLastReadTimestampVendor($vendor) : parent::getLastReadTimestamp();
    }

    /**
     * Returns last read timestamp for vendor
     *
     * @param \XLite\Model\Profile $vendor Vendor
     *
     * @return integer
     */
    protected function getLastReadTimestampVendor($vendor)
    {
        $vendorTimestamps = TmpVars::getInstance()->infoMenuReadTimestampVendor;

        return isset($vendorTimestamps[$vendor->getProfileId()])
            ? $vendorTimestamps[$vendor->getProfileId()]
            : 0;
    }
}
