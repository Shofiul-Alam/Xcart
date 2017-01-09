<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor;

use \XLite\Module\XC\MultiVendor;

/**
 * Vendors module main class
 */
abstract class Main extends \XLite\Module\AModule
{
    /**
     * Vendor configuration (runtime cache)
     *
     * @var array
     */
    protected static $configurationByVendor = array();

    /**
     * Configuration defaults
     *
     * @var array
     */
    protected static $commonConfigurationByPath = array();

    /**
     * Author name
     *
     * @return string
     */
    public static function getAuthorName()
    {
        return 'X-Cart team';
    }

    /**
     * Get module major version
     *
     * @return string
     */
    public static function getMajorVersion()
    {
        return '5.3';
    }

    /**
     * Module version
     *
     * @return string
     */
    public static function getMinorVersion()
    {
        return '2';
    }

    /**
     * Get module build number (4th number in the version)
     *
     * @return string
     */
    public static function getBuildVersion()
    {
        return '2';
    }

    /**
     * Module name
     *
     * @return string
     */
    public static function getModuleName()
    {
        return 'Multi-vendor';
    }

    /**
     * Module description
     *
     * @return string
     */
    public static function getDescription()
    {
        return 'Create an online mall where multiple vendors can sell their own products and '
            . 'manage their orders through a single marketplace.';
    }

    /**
     * Determines if we need to show settings form link
     *
     * @return boolean
     */
    public static function showSettingsForm()
    {
        return true;
    }

    /**
     * Method to initialize concrete module instance
     *
     * @return void
     */
    public static function init()
    {
        parent::init();

        if (\XLite\Core\Database::getRepo('XLite\Model\Module')->isModuleEnabled('XC\Reviews')) {
            MultiVendor\Core\VendorRatingProvider::getInstance()->addRatingsProvider(
                'reviews',
                new MultiVendor\Core\ReviewsVendorRating()
            );
            MultiVendor\Core\VendorRatingProvider::getInstance()->setCurrentProvider('reviews');
        }
    }

    /**
     * Check if module can be disabled
     *
     * @return boolean
     */
    public static function canDisable()
    {
        return false;
    }

    /**
     * Returns warehouse mode status
     *
     * @return boolean
     */
    public static function isWarehouseMode()
    {
        return 'W' === \XLite\Core\Config::getInstance()->XC->MultiVendor->multivendor_mode;
    }

    /**
     * Returns combines vendor configuration with default values from common configuration
     *
     * @param \XLite\Model\Profile $vendor Vendor
     * @param array                $path   Path
     *
     * @return \XLite\Core\ConfigCell
     */
    public static function getVendorConfiguration($vendor, array $path)
    {
        $commonConfiguration = static::getCommonConfigurationByPath($path);
        $mixedConfiguration = clone $commonConfiguration;

        $vendorConfiguration = static::getVendorConfigurationByPath($vendor, $path);

        foreach ($vendorConfiguration as $name => $value) {
            $mixedConfiguration->{$name} = $value;
        }

        return $mixedConfiguration;
    }

    /**
     * Return configuration defaults
     *
     * @param array   $path Path
     * @param boolean $raw  Return raw data
     *
     * @return \XLite\Core\ConfigCell|array
     */
    public static function getDefaultConfiguration($path, $raw = false)
    {
        $result = new \XLite\Core\ConfigCell();

        if (2 === count($path)) {
            $yamlFiles = \Includes\Utils\ModulesManager::getModuleYAMLFiles($path[0], $path[1]);
            if ($yamlFiles) {
                $data = \Symfony\Component\Yaml\Yaml::parse(array_shift($yamlFiles));
                $options = array();
                if ($data && isset($data['XLite\Model\Config'])) {
                    foreach ($data['XLite\Model\Config'] as $config) {
                        $options[] = new \XLite\Model\Config($config);
                    }
                }

                if ($options) {
                    $result = $raw
                        ? $options
                        : static::getConfigurationByPath(
                            \XLite\Core\Database::getRepo('XLite\Model\Config')->processOptions($options),
                            $path
                        );
                }
            }
        }

        return $result;
    }

    /**
     * Returns common configuration by path
     *
     * @param array $path Path
     *
     * @return \XLite\Core\ConfigCell
     */
    protected static function getCommonConfigurationByPath($path)
    {
        $key = implode('-', $path);

        if (!isset(static::$commonConfigurationByPath[$key])) {
            $configuration = clone static::getConfigurationByPath(\XLite\Core\Config::getInstance(), $path);
            $defaults = static::getDefaultConfiguration($path);

            if ($configuration) {
                foreach ($configuration as $name => $value) {
                    if (null !== $defaults->{$name}) {
                        $configuration->{$name} = $defaults->{$name};
                    }
                }

                static::$commonConfigurationByPath[$key] = $configuration;
            }
        }

        return static::$commonConfigurationByPath[$key];
    }

    /**
     * Returns vendor configuration by path
     *
     * @param \XLite\Model\Profile $vendor Vendor
     * @param array                $path   Path
     *
     * @return \XLite\Core\ConfigCell
     */
    protected static function getVendorConfigurationByPath($vendor, $path)
    {
        $result = null;

        if (null !== $vendor && $path) {
            $vendorId = $vendor->getProfileId();
            if (!isset(static::$configurationByVendor[$vendorId])) {
                /** @var \XLite\Model\Repo\Config $repo */
                $repo = Core\Database::getRepo('XLite\Model\Config');
                static::$configurationByVendor[$vendorId] = $repo->getAllVendorOptions($vendor);
            }

            $result = static::getConfigurationByPath(static::$configurationByVendor[$vendorId], $path);
        }

        return $result ?: new \XLite\Core\ConfigCell();
    }

    /**
     * Get configuration by path
     *
     * @param \XLite\Core\ConfigCell $configuration Configuration
     * @param array                  $path          Path
     *
     * @return \XLite\Core\ConfigCell
     */
    protected static function getConfigurationByPath($configuration, $path)
    {
        $result = null;

        if ($path) {
            $result = $configuration;
            while ($node = array_shift($path)) {
                $result = $result ? $result->{$node} : null;
            }
        }

        return $result ?: new \XLite\Core\ConfigCell();
    }

    /**
     * isReviewsEditAllowed
     *
     * @return boolean
     */
    public static function isReviewsChangeAllowed()
    {
        return \XLite\Core\Config::getInstance()->XC->MultiVendor->vendor_change_reviews_allowed;
    }

    /**
     * isReviewsEditAllowed
     *
     * @return boolean
     */
    public static function isReviewsChangeAllowedForCurrentUser()
    {
        return static::isReviewsChangeAllowed()
            || !\XLite\Core\Auth::getInstance()->isVendor();
    }
}
