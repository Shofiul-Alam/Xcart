<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View;

/**
 * Top sellers
 */
class TopSellers extends \XLite\View\TopSellers implements \XLite\Base\IDecorator
{
    const PARAM_VENDOR_ID = 'vendorId';

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_VENDOR_ID => new \XLite\Model\WidgetParam\TypeString(
                'Vendor id', ''
            ),
        );
    }

    /**
     * Define the "request" parameters
     *
     * @return void
     */
    protected function defineRequestParams()
    {
        parent::defineRequestParams();

        $this->requestParams[] = static::PARAM_VENDOR_ID;
    }

    /**
     * Return vendor id
     *
     * @return string
     */
    public function getVendorId()
    {
        $vendorId = $this->getParam(static::PARAM_VENDOR_ID);

        return $vendorId;
    }

    /**
     * Get CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/XC/MultiVendor/top_sellers/style.css';

        return $list;
    }

    /**
     * Get JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'modules/XC/MultiVendor/top_sellers/controller.js';

        return $list;
    }

    /**
     * Build link for vendor id
     *
     * @param string $vendorId
     *
     * @return string
     */
    public function getVendorLink($vendorId)
    {
        return $this->buildURL('top_sellers', '', [
            static::PARAM_VENDOR_ID => $vendorId
        ]);
    }

    /**
     * Process position value
     *
     * @param int $id
     * @param \XLite\Model\OrderItem | null $item
     *
     * @return string
     */
    public function processPositionValue($id, $item)
    {
        $result = parent::processPositionValue($id, $item);

        if (!$this->getVendorId() && $item && ($vendor = $item->getVendor())) {
            $result .= ' ' . $vendor->getVendorCompanyName();
        }

        return $result;
    }
}