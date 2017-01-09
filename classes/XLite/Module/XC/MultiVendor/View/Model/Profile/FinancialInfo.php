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
class FinancialInfo extends \XLite\Module\XC\MultiVendor\View\Model\Profile\Vendor
{
    /**
     * Schema of the "Financial info" section
     *
     * @var array
     */
    protected $schemaDefault= array(
        'paypalLogin'    => array(
            self::SCHEMA_CLASS    => 'XLite\Module\XC\MultiVendor\View\FormField\Input\PaypalLogin',
            self::SCHEMA_LABEL    => 'PayPal account (email)',
            self::SCHEMA_REQUIRED => false,
            MultiVendor\View\FormField\Input\PaypalLogin::PARAM_STATUS => '',
        ),
        'firstName'    => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'PayPal first name',
            self::SCHEMA_REQUIRED => false,
        ),
        'lastName'    => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'PayPal last name',
            self::SCHEMA_REQUIRED => false,
        ),
        'bankDetails' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Textarea\Simple',
            self::SCHEMA_LABEL    => 'Bank details',
            self::SCHEMA_REQUIRED => false,
        ),
    );

    /**
     * Return title
     *
     * @return string
     */
    protected function getHead()
    {
        return 'Financial info';
    }

    /**
     * Return name of web form widget class
     *
     * @return string
     */
    protected function getFormClass()
    {
        return 'XLite\Module\XC\MultiVendor\View\Form\Profile\FinancialInfo';
    }

    /**
     * getFieldBySchema
     *
     * @param string $name Field name
     * @param array  $data Field description
     *
     * @return \XLite\View\FormField\AFormField
     */
    protected function getFieldBySchema($name, array $data)
    {
        if ('paypalLogin' === $name) {
            $data[MultiVendor\View\FormField\Input\PaypalLogin::PARAM_STATUS] = $this->getModelObject()->getPaypalLoginStatus();
        }

        return parent::getFieldBySchema($name, $data);
    }

    /**
     * Validate 'container' field (domestic).
     * Return array (<bool: isValid>, <string: error message>)
     *
     * @param \XLite\View\FormField\AFormField $field Form field object
     * @param array                            $data  List of all fields
     *
     * @return array
     */
    protected function validateFormFieldPaypalLoginValue($field, $data)
    {
        $errorMessage = null;
        $exists = \XLite\Core\Database::getRepo('XLite\Model\Profile')->findOneBy([
            'paypalLogin'   => $field
                ? $field->getValue()
                : null,
        ]);

        if ($exists
            && $this->getModelObject()
            && $exists->getProfileId() !== $this->getModelObject()->getProfileId()
        ) {
            $errorMessage = static::t(
                'Paypal login {{value}} already registered',
                array('value' => $field->getValue())
            );
        }

        return array(empty($errorMessage), $errorMessage);
    }
}
