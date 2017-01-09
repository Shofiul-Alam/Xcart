<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\VolumeDiscounts\View\ItemsList;

use XLite\Core;
use XLite\Model;

/**
 * Volume discounts items list
 *
 * @Decorator\Depend ("CDev\VolumeDiscounts")
 */
class VolumeDiscounts extends \XLite\Module\CDev\VolumeDiscounts\View\ItemsList\VolumeDiscounts implements \XLite\Base\IDecorator
{
    const PARAM_VENDOR_ID = 'vendorId';
    const PARAM_VENDOR    = 'vendor';

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        $columns = parent::defineColumns();

        $columns['vendor_login'] = array(
            static::COLUMN_NAME    => static::t('Vendor'),
            static::COLUMN_LINK    => 'profile',
            static::COLUMN_NO_WRAP => true,
            static::COLUMN_ORDERBY => 500,
        );

        return $columns;
    }

    /**
     * Build entity page URL
     *
     * @param \XLite\Model\AEntity $product Entity
     * @param array                $column  Column data
     *
     * @return string
     */
    protected function buildEntityURL(Model\AEntity $discount, array $column)
    {
        $url = '';

        if ($column[static::COLUMN_LINK] === 'profile') {
            if ($discount->getVendor()) {
                $url = $this->buildURL(
                    $column[static::COLUMN_LINK],
                    '',
                    array('profile_id' => $discount->getVendor()->getProfileId())
                );
            }

        } else {
            $url = parent::buildEntityURL($discount, $column);
        }

        return $url;
    }

    /**
     * Create entity
     *
     * @return \XLite\Model\AEntity
     */
    protected function createEntity()
    {
        $entity = parent::createEntity();
        if (Core\Auth::getInstance()->isVendor()) {
            $entity->setVendor(Core\Auth::getInstance()->getProfile());
        } else {
            $vendor = Core\Database::getRepo('XLite\Model\Profile')->find(
                $this->getCondition(\XLite\Module\CDev\VolumeDiscounts\Model\Repo\VolumeDiscount::P_VENDOR_ID)
            );

            if ($vendor && $vendor->isVendor()) {
                $entity->setVendor($vendor);
            }
        }

        return $entity;
    }

    // {{{ Search

    /**
     * Return search parameters
     *
     * @return array
     */
    public static function getSearchParams()
    {
        return array(
            \XLite\Module\CDev\VolumeDiscounts\Model\Repo\VolumeDiscount::P_VENDOR_ID => static::PARAM_VENDOR_ID,
            'vendor' => static::PARAM_VENDOR,
        );
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_VENDOR_ID => new Model\WidgetParam\TypeInt('Vendor ID', $this->getDefaultVendorId()),
            static::PARAM_VENDOR    => new Model\WidgetParam\TypeString('Vendor', ''),
        );
    }

    /**
     * Define so called "request" parameters
     *
     * @return void
     */
    protected function defineRequestParams()
    {
        parent::defineRequestParams();

        $this->requestParams = array_merge($this->requestParams, static::getSearchParams());
    }

    /**
     * Return params list to use for search
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getSearchCondition()
    {
        $result = parent::getSearchCondition();
        foreach (static::getSearchParams() as $modelParam => $requestParam) {
            $result->$modelParam = is_string($this->getParam($requestParam))
                ? trim($this->getParam($requestParam))
                : $this->getParam($requestParam);
        }

        return $result;
    }

    /**
     * @return bool
     */
    protected function getDefaultVendorId()
    {
        return Core\Auth::getInstance()->isVendor()
            ? Core\Auth::getInstance()->getProfile()->getProfileId()
            : Model\Repo\Profile::ADMIN_VENDOR_FAKE_ID;
    }

    // }}}
}
