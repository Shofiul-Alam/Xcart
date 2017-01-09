<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormField\Input;

use \XLite\Module\CDev\Paypal;

/**
 * PaypalLogin input
 */
class PaypalLogin extends \XLite\View\FormField\AFormField
{
    /**
     * PaypalLogin field type
     */
    const FIELD_TYPE_PAYPAL_LOGIN = 'paypal_login';

    /**
     * Widget param names
     */
    const PARAM_STATUS = 'status';

    /**
     * Define widget params
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            self::PARAM_STATUS => new \XLite\Model\WidgetParam\TypeString(
                'Status',
                \XLite\Model\Profile::PAYPAL_LOGIN_NOT_EXISTS
            ),
        );
    }

    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'modules/XC/MultiVendor/form_field/paypal_login.css';

        return $list;
    }

    /**
     * getValue
     *
     * @return string
     */
    public function isCheckAvailable()
    {
        return false;
    }

    /**
     * getValue
     *
     * @return string
     */
    public function isExists()
    {
        return $this->getParam(self::PARAM_STATUS) !== \XLite\Model\Profile::PAYPAL_LOGIN_NOT_EXISTS;
    }

    /**
     * getValue
     *
     * @return string
     */
    public function isVerified()
    {
        return $this->getParam(self::PARAM_STATUS) === \XLite\Model\Profile::PAYPAL_LOGIN_VERIFIED;
    }

    /**
     * Return field type
     *
     * @return string
     */
    public function getFieldType()
    {
        return static::FIELD_TYPE_PAYPAL_LOGIN;
    }

    /**
     * Return name of the folder with templates
     *
     * @return string
     */
    protected function getDir()
    {
        return 'modules/XC/MultiVendor/form_field';
    }

    /**
     * Return field template
     *
     * @return string
     */
    protected function getFieldTemplate()
    {
        return 'paypal_login.twig';
    }
}
