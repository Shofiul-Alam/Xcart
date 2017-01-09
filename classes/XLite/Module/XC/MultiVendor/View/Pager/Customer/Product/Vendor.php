<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Pager\Customer\Product;

use XLite\Module\XC\MultiVendor\Model\WidgetParam\ObjectId\Vendor as VendorObjectId;

/**
 * Pager for the vendor products page
 */
class Vendor extends \XLite\View\Pager\Customer\Product\AProduct
{
    /**
     * Widget parameter names
     */

    const PARAM_VENDOR_ID = 'vendor_id';

    /**
     * Return current vendor model object
     *
     * @return \XLite\Model\Profile
     */
    protected function getVendor()
    {
        return $this->getWidgetParams(static::PARAM_VENDOR_ID)->getObject();
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(static::PARAM_VENDOR_ID => new VendorObjectId('Vendor ID', null));
    }

    /**
     * Define so called "request" parameters
     *
     * @return void
     */
    protected function defineRequestParams()
    {
        parent::defineRequestParams();

        if (!$this->isAJAX()) {
            unset($this->requestParams[array_search(static::PARAM_PAGE_ID, $this->requestParams)]);
        }

        $this->requestParams[] = static::PARAM_VENDOR_ID;
    }
}
