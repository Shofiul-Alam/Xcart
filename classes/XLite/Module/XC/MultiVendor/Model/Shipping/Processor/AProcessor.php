<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\Shipping\Processor;

use XLite\Core;
use XLite\Module\XC\MultiVendor;

/**
 * Shipping processor model
 */
abstract class AProcessor extends \XLite\Model\Shipping\Processor\AProcessor implements \XLite\Base\IDecorator
{
    /**
     * Vendor
     *
     * @var \XLite\Model\Profile
     */
    protected $vendor;

    /**
     * Enabled state by vendor
     *
     * @var array
     */
    protected $enabledByVendor = array();

    /**
     * Configuration cache by vendor
     *
     * @var array
     */
    protected $configurationByVendor = array();

    /**
     * Methods cache by vendor
     *
     * @var array
     */
    protected $methodsByVendor = array();

    /**
     * Set vendor
     *
     * @param \XLite\Model\Profile $vendor Vendor
     *
     * @return void
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * Returns current vendor
     *
     * @return \XLite\Model\Profile
     */
    public function getVendor()
    {
        return \XLite::isAdminZone() && Core\Auth::getInstance()->isVendor()
            ? Core\Auth::getInstance()->getVendor()
            : $this->vendor;
    }

    /**
     * Fetch methods from database
     *
     * @return \XLite\Model\Shipping\Method[]
     */
    protected function fetchMethods()
    {
        $vendor = $this->getVendor();
        if (null !== $vendor) {
            if (!isset($this->methodsByVendor[$vendor->getProfileId()])) {
                /** @var \XLite\Model\Repo\Shipping\Method $repo */
                $repo = \XLite\Core\Database::getRepo('XLite\Model\Shipping\Method');
                $onlineMethods = $repo->findMethodsByProcessorAndVendor($this->getProcessorId(), $vendor, false);

                $this->methodsByVendor[$vendor->getProfileId()] = $onlineMethods;
            }

            $result = $this->methodsByVendor[$vendor->getProfileId()];

        } else {
            $result = parent::fetchMethods();
        }

        return $result;
    }

    /**
     * Prepare data for methods creation
     *
     * @param string  $code    Method code
     * @param string  $name    Method name
     * @param boolean $enabled Enabled state OPTIONAL
     *
     * @return array
     */
    protected function prepareCreateMethodData($code, $name, $enabled = true)
    {
        $result = parent::prepareCreateMethodData($code, $name, $enabled);

        $vendor = $this->getVendor();
        if (null !== $vendor) {
            $result['vendor'] = $vendor;
        }

        return $result;
    }

    /**
     * Returns activity status
     *
     * @return boolean
     */
    public function isEnabled()
    {
        $vendor = $this->getVendor();
        if (null !== $vendor) {
            if (!isset($this->enabledByVendor[$vendor->getProfileId()])) {
                /** @var \XLite\Model\Repo\Shipping\Method $repo */
                $repo = \XLite\Core\Database::getRepo('XLite\Model\Shipping\Method');
                $onlineMethod = $repo->findOnlineCarrierByVendor($this->getProcessorId(), $vendor);

                $this->enabledByVendor[$vendor->getProfileId()] = $onlineMethod
                    ? $onlineMethod->getEnabled()
                    : false;
            }

            $result = $this->enabledByVendor[$vendor->getProfileId()];

        } else {
            $result = parent::isEnabled();
        }

        return $result;
    }

    /**
     * Returns current configuration
     *
     * @return \XLite\Core\ConfigCell
     */
    protected function getConfiguration()
    {
        $vendor = $this->getVendor();

        return null !== $vendor
            ? MultiVendor\Main::getVendorConfiguration($vendor, $this->getConfigurationPath())
            : parent::getConfiguration();
    }
}
