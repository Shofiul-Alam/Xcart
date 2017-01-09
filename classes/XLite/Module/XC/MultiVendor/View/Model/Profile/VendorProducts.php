<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Model\Profile;

use XLite\Module\XC\MultiVendor;

/**
 * Administrator profile model widget. This widget is used in the admin interface
 */
class VendorProducts extends \XLite\Module\XC\MultiVendor\View\Model\Profile\Vendor
{
    /**
     * Schema of the "Financial info" section
     *
     * @var array
     */
    protected $schemaDefault= array(

    );

    /**
     * Return title
     *
     * @return string
     */
    protected function getHead()
    {
        return 'Vendor products';
    }

    /**
     * Return name of web form widget class
     *
     * @return string
     */
    protected function getFormClass()
    {
        return 'XLite\Module\XC\MultiVendor\View\Form\Profile\VendorProducts';
    }
}
