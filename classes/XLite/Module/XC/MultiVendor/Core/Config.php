<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Core;

use \XLite\Core;

/**
 * DB-based configuration registry
 */
class Config extends \XLite\Core\Config implements \XLite\Base\IDecorator
{
    /**
     * Config (runtime cache)
     *
     * @var \XLite\Core\ConfigCell[]
     */
    protected $configByVendor = array();

    /**
     * Merge config
     *
     * @param \XLite\Core\ConfigCell $commonConfig Common config
     * @param \XLite\Core\ConfigCell $vendorConfig Vendor config
     *
     * @return void
     */
    protected static function mergeConfig($commonConfig, $vendorConfig)
    {
        foreach ($vendorConfig as $category => $values) {
            $commonNode = $commonConfig->{$category};
            if ($commonNode) {
                static::mergeCategoryConfig($commonNode, $values);
            }
        }
    }

    /**
     * Merge Category config
     *
     * @param \XLite\Core\ConfigCell $commonConfig Common config
     * @param \XLite\Core\ConfigCell $vendorConfig Vendor config
     *
     * @return void
     */
    protected static function mergeCategoryConfig($commonConfig, $vendorConfig)
    {
        foreach ($vendorConfig as $name => $value) {
            $commonNode = $commonConfig->{$name};
            if ($commonNode) {
                if ($value instanceof Core\ConfigCell) {
                    static::mergeCategoryConfig($commonNode, $value);

                } else {
                    $commonConfig->{$name} = $value;
                }
            }
        }
    }

    /**
     * Read config from database
     *
     * @param boolean $force Force OPTIONAL
     *
     * @return \XLite\Core\ConfigCell
     */
    protected function readFromDatabase($force = false)
    {
        $result = parent::readFromDatabase($force);

        $vendor = Core\Auth::getInstance()->getVendor();
        if ($vendor && \XLite::isAdminZone()) {
            static::mergeConfig($result, $this->readVendorConfigFromDatabase($vendor, $force));
        }

        return $result;
    }

    /**
     * Read vendor config from database
     *
     * @param \XLite\Model\Profile|integer|null $vendor Vendor
     * @param boolean                           $force  Force OPTIONAL
     *
     * @return \XLite\Core\ConfigCell
     */
    protected function readVendorConfigFromDatabase($vendor, $force)
    {
        /** @var \XLite\Model\Repo\Config $repo */
        $repo = Core\Database::getRepo('XLite\Model\Config');

        return $repo->getAllVendorOptions($vendor, $force);
    }
}
