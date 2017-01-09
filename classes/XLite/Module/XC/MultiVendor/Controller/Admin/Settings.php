<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Admin;

use XLite\Core\Auth;
use XLite\Module\XC\MultiVendor;

/**
 * Shipping methods management page controller
 */
abstract class Settings extends \XLite\Controller\Admin\Settings implements \XLite\Base\IDecorator
{
    /**
     * Get tab names
     *
     * @return array
     */
    public function getPages()
    {
        $list = parent::getPages();
        $warehouseMode = MultiVendor\Main::isWarehouseMode();

        if (!$warehouseMode && Auth::getInstance()->isVendor()) {
            $list = array_intersect_key($list, array_flip(array(static::COMPANY_PAGE)));

            $list[static::COMPANY_PAGE] = static::t('Store address');
        }

        return $list;
    }

    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        $warehouseMode = MultiVendor\Main::isWarehouseMode();

        return parent::checkACL()
            || (!$warehouseMode
                && Auth::getInstance()->isPermissionAllowed('[vendor] manage shipping')
                && ($this instanceof \XLite\Controller\Admin\ShippingSettings
                    || $this->page === static::COMPANY_PAGE
                )
            );
    }

    /**
     * Get options for current tab (category)
     *
     * @return array
     */
    public function getOptions()
    {
        $result = array();

        $list = parent::getOptions();
        if (Auth::getInstance()->isVendor()) {
            foreach ($list as $option) {
                if (in_array($option->getName(), $this->getAllowedOptions(), true)) {
                    $result[] = $option;
                }
            }
        } else {
            $result = $list;
        }

        return $result;
    }

    /**
     * Returns allowed options
     *
     * @return array
     */
    protected function getAllowedOptions()
    {
        return array(
            'location_address',
            'location_country',
            'location_state',
            'location_custom_state',
            'location_city',
            'location_zipcode',
        );
    }
}
