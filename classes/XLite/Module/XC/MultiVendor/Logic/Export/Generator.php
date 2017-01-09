<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Logic\Export;

use XLite\Core;
use XLite\Module\XC\MultiVendor;

/**
 * Generator
 */
class Generator extends \XLite\Logic\Export\Generator implements \XLite\Base\IDecorator
{
    /**
     * Vendor export directory path prefix (to be suffixed with vendor id)
     */
    const EXPORT_DIR_VENDOR_PREFIX = 'export-vendor-';

    /**
     * Get exportTickDuration TmpVar name
     *
     * @return string
     */
    public static function getTickDurationVarName()
    {
        return MultiVendor\Logic\Vendors::getVendorPrefixedName(parent::getTickDurationVarName());
    }

    /**
     * Get export event name
     *
     * @return string
     */
    public static function getEventName()
    {
        return MultiVendor\Logic\Vendors::getVendorPrefixedName(parent::getEventName());
    }

    /**
     * Get export cancel flag name
     *
     * @return string
     */
    public static function getCancelFlagVarName()
    {
        return MultiVendor\Logic\Vendors::getVendorPrefixedName(parent::getCancelFlagVarName());
    }

    /**
     * Constructor
     *
     * @param array $options Options OPTIONAL
     *
     * @return \XLite\Module\XC\MultiVendor\Logic\Export\Generator
     */
    public function __construct(array $options = array())
    {
        if (Core\Auth::getInstance()->isVendor()) {
            $options['dir'] = $this->getVendorExportDir();

            if ($options['include']) {
                $options['include'] = array_intersect(
                    $options['include'],
                    $this->getExportSectionsAllowedForVendor()
                );

                if (empty($options['include'])) {
                    $options['include'] = $this->getExportSectionsAllowedForVendor();
                }
            }
        }

        parent::__construct($options);
    }

    /**
     * Get allowed export types
     *
     * @return array
     */
    protected function getExportSectionsAllowedForVendor()
    {
        return array(
            'XLite\Logic\Export\Step\Products',
        );
    }

    /**
     * Get vendor own export path
     *
     * @return string
     */
    protected function getVendorExportDir()
    {
        return static::EXPORT_DIR_VENDOR_PREFIX . Core\Auth::getInstance()->getVendorId();
    }
}
