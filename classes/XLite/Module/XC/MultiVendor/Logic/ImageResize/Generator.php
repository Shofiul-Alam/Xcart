<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Logic\ImageResize;

use XLite\Module\XC\MultiVendor;

/**
 * ImageResize
 */
class Generator extends \XLite\Logic\ImageResize\Generator implements \XLite\Base\IDecorator
{
    const MODEL_VENDOR = 'XLite\Module\XC\MultiVendor\Model\Image\Vendor';

    /**
     * Returns available image sizes
     *
     * @return array
     */
    public static function defineImageSizes()
    {
        $result = parent::defineImageSizes();
        $result[static::MODEL_VENDOR] = array(
            array(122, 122),
            array(
                MultiVendor\View\ProductVendorInfo::VENDOR_IMAGE_MAX_WIDTH,
                MultiVendor\View\ProductVendorInfo::VENDOR_IMAGE_MAX_HEIGHT
            ),
            array(
                MultiVendor\View\VendorInfoBlockContent::VENDOR_IMAGE_MAX_WIDTH,
                MultiVendor\View\VendorInfoBlockContent::VENDOR_IMAGE_MAX_HEIGHT
            ),
        );

        return $result;
    }

    /**
     * Define steps
     *
     * @return array
     */
    protected function defineSteps()
    {
        $list = parent::defineSteps();
        $list[] = 'XLite\Module\XC\MultiVendor\Logic\ImageResize\Step\Vendor';

        return $list;
    }
}
