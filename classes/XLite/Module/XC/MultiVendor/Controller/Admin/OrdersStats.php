<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Admin;

use XLite\Core;
use XLite\Model\Repo;

/**
 * Orders statistics page controller
 */
abstract class OrdersStats extends \XLite\Controller\Admin\OrdersStats implements \XLite\Base\IDecorator
{
    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        return parent::checkACL() || Core\Auth::getInstance()->isPermissionAllowed('[vendor] manage orders');
    }

    /**
     * Returns current vendor name
     *
     * @return string
     */
    public function getSelectedVendor()
    {
        $result = '';
        $vendorId = Core\Request::getInstance()->vendorId;

        if (Repo\Profile::ADMIN_VENDOR_FAKE_ID === (int) $vendorId) {
            $result = static::t('Administrator');

        } else {
            $vendor = $this->getVendor($vendorId);

            if ($vendor && $vendor->isVendor()) {
                $result = $vendor->getVendorCompanyName() . ' (' . $vendor->getLogin() . ')';
            }
        }

        return $result;
    }

    /**
     * Show vendor selector
     *
     * @return boolean
     */
    public function showVendorSelector()
    {
        return !Core\Auth::getInstance()->isVendor();
    }

    /**
     * Check if vendor id points to vendor
     *
     * @param integer $vendorId Vendor id
     *
     * @return \XLite\Model\Profile
     */
    protected function getVendor($vendorId)
    {
        return Core\Database::getRepo('XLite\Model\Profile')->find($vendorId);
    }

    /**
     * Returns statistic condition
     *
     * @param integer $startTime Start time
     *
     * @return \XLite\Core\CommonCell
     */
    protected function defineGetDataCountCondition($startTime)
    {
        $condition = parent::defineGetDataCountCondition($startTime);

        if (!Core\Auth::getInstance()->isVendor()
            && isset(Core\Request::getInstance()->vendorId)
        ) {
            $condition->vendor_id = Core\Request::getInstance()->vendorId;
        }

        return $condition;
    }

    /**
     * Returns statistic condition
     *
     * @param integer $startTime Start time
     *
     * @return \XLite\Core\CommonCell
     */
    protected function defineGetDataTotalCondition($startTime)
    {
        $condition = parent::defineGetDataTotalCondition($startTime);

        if (!Core\Auth::getInstance()->isVendor()
            && isset(Core\Request::getInstance()->vendorId)
        ) {
            $condition->vendor_id = Core\Request::getInstance()->vendorId;
        }

        return $condition;
    }
}
