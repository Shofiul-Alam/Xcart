<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\VolumeDiscounts\Controller\Admin;

use XLite\Core;
use XLite\Model;
use XLite\Module\CDev\VolumeDiscounts;

/**
 * Coupon
 *
 * @Decorator\Depend ("CDev\VolumeDiscounts")
 */
class Promotions extends \XLite\Controller\Admin\Promotions implements \XLite\Base\IDecorator
{
    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        return parent::checkACL() || Core\Auth::getInstance()->isPermissionAllowed('[vendor] manage catalog');
    }

    /**
     * Get pages static
     *
     * @return array
     */
    public static function getPagesStatic()
    {
        $list = parent::getPagesStatic();
        if (isset($list[static::PAGE_VOLUME_DISCOUNTS], $list[static::PAGE_VOLUME_DISCOUNTS]['permission'])
            && Core\Auth::getInstance()->isVendor()
        ) {
            $list[static::PAGE_VOLUME_DISCOUNTS]['permission'] = '[vendor] manage catalog';
        }

        if (!Core\Auth::getInstance()->isVendor()) {
            $list[static::PAGE_VOLUME_DISCOUNTS]['tpl'] = 'modules/XC/MultiVendor/modules/CDev/VolumeDiscounts/discounts/body.twig';
        }

        return $list;
    }

    /**
     * Is volume discount search visible
     *
     * @return boolean
     */
    public function isVolumeDiscountSearchVisible()
    {
        return !Core\Auth::getInstance()->isVendor();
    }

    /**
     * Get search condition parameter by name
     *
     * @param string $name Parameter name
     *
     * @return mixed
     */
    public function getCondition($name)
    {
        $result = null;
        if (static::PAGE_VOLUME_DISCOUNTS === $this->getPage()) {
            $result = $this->getVolumeDiscountCondition($name);
        }

        return $result;
    }

    /**
     * Get search condition parameter by name
     *
     * @param string $name Parameter name
     *
     * @return mixed
     */
    public function getVolumeDiscountCondition($name)
    {
        $searchParams = $this->getVolumeDiscountConditions();

        return isset($searchParams[$name])
            ? $searchParams[$name]
            : null;

    }

    /**
     * Get search conditions
     *
     * @return array
     */
    protected function getVolumeDiscountConditions()
    {
        $searchParams = \XLite\Core\Session::getInstance()
            ->{VolumeDiscounts\View\ItemsList\VolumeDiscounts::getSessionCellName()};

        return is_array($searchParams) ? $searchParams : array();
    }

    /**
     * Check - search panel is visible or not
     *
     * @return boolean
     */
    public function isSearchVisible()
    {
        return 0 < \XLite\Core\Database::getRepo('XLite\Model\Product')->count();
    }

    /**
     * Do action search
     *
     * @return void
     */
    protected function doActionSearch()
    {
        \XLite\Core\Session::getInstance()
            ->{\XLite\View\ItemsList\Model\Product\Admin\Search::getSessionCellName()} = $this->getSearchParams();

        $this->setReturnURL($this->getURL(array('mode' => 'search', 'searched' => 1)));
    }

    /**
     * Return search parameters for product list.
     * It is based on search params from Product Items list viewer
     *
     * @return array
     */
    protected function getSearchParams()
    {
        $result = array();

        foreach (
            \XLite\Module\CDev\VolumeDiscounts\View\ItemsList\VolumeDiscounts::getSearchParams() as $requestParam
        ) {
            if (isset(\XLite\Core\Request::getInstance()->$requestParam)) {
                $result[$requestParam] = \XLite\Core\Request::getInstance()->$requestParam;
            }
        }

        return $result;
    }

    /**
     * Get search conditions
     *
     * @return array
     */
    protected function getConditions()
    {
        $searchParams = \XLite\Core\Session::getInstance()
            ->{\XLite\Module\CDev\VolumeDiscounts\View\ItemsList\VolumeDiscounts::getSessionCellName()};

        if (!is_array($searchParams)) {
            $searchParams = array();
        }

        return $searchParams;
    }
}
