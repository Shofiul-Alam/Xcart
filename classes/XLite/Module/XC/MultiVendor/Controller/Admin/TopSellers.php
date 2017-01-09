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
 * Top sellers statistics page controller
 */
abstract class TopSellers extends \XLite\Controller\Admin\TopSellers implements \XLite\Base\IDecorator
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
        $vendorId = $this->getVendorId();

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
     * Return vendor id from request or saved value
     *
     * @return mixed
     */
    public function getVendorId()
    {
        $vendorId = Core\Request::getInstance()->vendorId;

        if (null === $vendorId) {
            $sessionCell = \XLite\Core\Session::getInstance()->{\XLite\View\TopSellers::getSessionCellName()};
            $vendorId = isset($sessionCell[\XLite\View\TopSellers::PARAM_VENDOR_ID])
                ? $sessionCell[\XLite\View\TopSellers::PARAM_VENDOR_ID]
                : $vendorId;
        }

        return $vendorId;
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
     * Define condition fo getData
     *
     * @param string $interval Time interval
     *
     * @return \XLite\Core\CommonCell
     */
    protected function defineDetDataCondition($interval)
    {
        $condition = parent::defineDetDataCondition($interval);
        $vendorId = $this->getVendorId();

        if (!Core\Auth::getInstance()->isVendor()
            && !empty($vendorId)
        ) {
            $condition->vendor_id = $this->getVendorId();
        }

        return $condition;
    }
}
