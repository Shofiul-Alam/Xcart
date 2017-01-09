<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Core;

/**
 * Vendor rating data prodiver
 */
class VendorRatingProvider extends \XLite\Base
{
    protected $providers = array();

    protected $currentProvider = null;

    /**
     * Add ratings data provider
     *
     * @param string                                                $name       Provider service name
     * @param \XLite\Module\XC\MultiVendor\Core\IRatingsProvider    $provider   Provider instance
     */
    public function addRatingsProvider($name, \XLite\Module\XC\MultiVendor\Core\IVendorRatingsProvider $provider)
    {
        $this->providers[$name] = $provider;
    }

    /**
     * Set current ratings data provider
     *
     * @param string    $name  Provider service name
     */
    public function setCurrentProvider($name)
    {
        if (!array_key_exists($name, $this->providers)) {
            throw new \InvalidArgumentException("Undefined VendorRatingBlock name: " . $name, 1);
        }

        $this->currentProvider = $name;
    }

    /**
     * Get ratings data provider
     *
     * @return \XLite\Module\XC\MultiVendor\Core\IRatingsProvider
     */
    public function getProvider()
    {
        return $this->providers && isset($this->providers[$this->currentProvider])
            ? $this->providers[$this->currentProvider]
            : null;
    }
}
