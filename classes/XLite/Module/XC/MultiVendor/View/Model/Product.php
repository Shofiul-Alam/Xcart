<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Model;

use XLite\Core;
use XLite\Model\Repo;
use XLite\Module\XC\MultiVendor;

/**
 * Product model widget extension
 */
class Product extends \XLite\View\Model\Product implements \XLite\Base\IDecorator
{
    /**
     * Add vendor field right after SKU
     *
     * @param array $params Widget params OPTIONAL
     * @param array $sections Sections list OPTIONAL
     */
    public function __construct(array $params = array(), array $sections = array())
    {
        parent::__construct($params, $sections);

        if (Core\Auth::getInstance()->hasRootAccess()) {
            $vendorField = array(
                static::SCHEMA_CLASS => 'XLite\Module\XC\MultiVendor\View\FormField\Select\Product\Vendor',
                static::SCHEMA_LABEL => 'Vendor',
                static::SCHEMA_REQUIRED => false,
            );

            $this->schemaDefault = array('vendor' => $vendorField) + $this->schemaDefault;
        }
    }

    /**
     * Return model object to use
     *
     * @return \XLite\Model\Product
     */
    public function getModelObject()
    {
        $entity = parent::getModelObject();
        $vendor = Core\Auth::getInstance()->getVendor();

        if ($entity && $vendor) {
            $entity->setVendor($vendor);
        }

        return $entity;
    }

    /**
     * This object will be used if another one is not passed
     *
     * @return \XLite\Model\Product
     */
    protected function getDefaultModelObject()
    {
        $entity = parent::getDefaultModelObject();
        $vendor = Core\Auth::getInstance()->getVendor();

        if ($entity && $vendor) {
            $entity->setVendor($vendor);
        }

        return $entity;
    }

    /**
     * Populate model object properties by the passed data.
     * Specific wrapper for setModelProperties method.
     *
     * @param array $data Data to set
     *
     * @return void
     */
    protected function updateModelProperties(array $data)
    {
        if (!empty($data['vendor']) && Core\Auth::getInstance()->hasRootAccess()) {
            $vendorId = reset($data['vendor']);
            $vendor = Core\Database::getRepo('XLite\Model\Profile')->find($vendorId);

            if ($vendor && $vendor->isVendor()) {
                $data['vendor'] = $vendor;

            } else {
                $data['vendor'] = null;
            }

            $product = $this->getModelObject();
            if ($product && $product->isPersistent()) {
                \XLite\Core\Database::getRepo('XLite\Model\OrderItem')->detachVendorProduct($product);
            }
        }

        parent::updateModelProperties($data);
    }

    /**
     * Preparing data for price param
     *
     * @param array $data Field description
     *
     * @return array
     */
    protected function prepareFieldParamsVendor($data)
    {
        $product = $this->getModelObject();

        if ($product->isPersistent() && $product->getOrdersCount()) {
            $data[MultiVendor\View\FormField\Select\Product\Vendor::PARAM_HAS_ORDERS] = true;

            $vendorId = Repo\Profile::ADMIN_VENDOR_FAKE_ID;
            $vendor = static::t('Administrator');

            if ($product->getVendor()) {
                $profile = $product->getVendor();
                $vendorId = $profile->getProfileId();
                $vendor = $profile->getVendorCompanyName() . ' (' . $profile->getLogin() . ')';
            }

            $url = $this->buildURL('order_list', 'search', array(
                'vendorId' => $vendorId,
                'vendor' => $vendor,
                'sku' => $product->getSku()
            ));
            $data[MultiVendor\View\FormField\Select\Product\Vendor::PARAM_ORDERS_URL] = $url;
        }

        return $data;
    }
}
