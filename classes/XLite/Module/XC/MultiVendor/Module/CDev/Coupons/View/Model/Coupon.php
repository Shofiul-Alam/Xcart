<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\CDev\Coupons\View\Model;

use XLite\Core;

/**
 * Coupon
 *
 * @Decorator\Depend ("CDev\Coupons")
 */
class Coupon extends \XLite\Module\CDev\Coupons\View\Model\Coupon implements \XLite\Base\IDecorator
{
    /**
     * Add vendor field right after SKU
     *
     * @param array $params   Widget params OPTIONAL
     * @param array $sections Sections list OPTIONAL
     */
    public function __construct(array $params = array(), array $sections = array())
    {
        parent::__construct($params, $sections);

        if (!Core\Auth::getInstance()->isVendor()) {
            $vendorField = array(
                static::SCHEMA_CLASS => 'XLite\Module\XC\MultiVendor\View\FormField\Input\Autocomplete\Vendor',
                static::SCHEMA_LABEL => 'Vendor',
                static::SCHEMA_REQUIRED => false,
                \XLite\View\FormField\Input\AInput::PARAM_PLACEHOLDER => static::t('Email or Company name'),
            );

            $this->schemaDefault = array('vendor' => $vendorField) + $this->schemaDefault;
        }
    }

    /**
     * Return model object to use
     *
     * @return \XLite\Module\CDev\Coupons\Model\Coupon
     */
    public function getModelObject()
    {
        $entity = parent::getModelObject();
        $auth = Core\Auth::getInstance();

        if ($entity && $auth->isVendor()) {
            $entity->setVendor($auth->getVendor());
        }

        return $entity;
    }

    /**
     * This object will be used if another one is not passed
     *
     * @return \XLite\Module\CDev\Coupons\Model\Coupon
     */
    protected function getDefaultModelObject()
    {
        $entity = parent::getDefaultModelObject();
        $auth = Core\Auth::getInstance();

        if ($entity && $auth->isVendor()) {
            $entity->setVendor($auth->getVendor());
        }

        return $entity;
    }

    /**
     * Populate model object properties by the passed data
     *
     * @param array $data Data to set
     *
     * @return void
     */
    protected function setModelProperties(array $data)
    {
        $auth = Core\Auth::getInstance();
        $vendorId = Core\Request::getInstance()->vendorId;

        $vendor = $auth->isVendor()
            ? $auth->getVendor()
            : Core\Database::getRepo('XLite\Model\Profile')->find($vendorId);

        $data['vendor'] = $vendor && $vendor->isVendor()
            ? $vendor
            : null;

        parent::setModelProperties($data);
    }

    /**
     * Retrieve property from the model object
     *
     * @param mixed $name Field/property name
     *
     * @return mixed
     */
    protected function getModelObjectValue($name)
    {
        switch ($name) {
            case 'vendor':
                $result = '';
                $model = $this->getModelObject();
                if ($model->getId()) {
                    if ($model->getVendor()) {
                        $vendor = $model->getVendor();
                        $result = $vendor->getVendorCompanyName() . ' (' . $vendor->getLogin() . ')';
                    } else {
                        $result = static::t('Administrator');
                    }
                }
                break;

            default:
                $result = parent::getModelObjectValue($name);
        }

        return $result;
    }
}
