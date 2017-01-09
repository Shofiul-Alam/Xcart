<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormField\Select\Product;

use XLite\Model\Repo;

/**
 * Vendor profiles select
 */
class Vendor extends \XLite\Module\XC\MultiVendor\View\FormField\Select\Vendor
{
    const PARAM_HAS_ORDERS = 'hasOrders';
    const PARAM_ORDERS_URL = 'ordersUrl';

    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'modules/XC/MultiVendor/form_field/vendor/controller.js';

        return $list;
    }

    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/XC/MultiVendor/form_field/vendor/style.css';

        return $list;
    }

    /**
     * Register files from common repository
     *
     * @return array
     */
    protected function getCommonFiles()
    {
        $list = parent::getCommonFiles();

        $list[static::RESOURCE_JS][] = 'js/chosen.jquery.js';

        $list[static::RESOURCE_CSS][] = 'css/chosen/chosen.css';

        return $list;
    }

    /**
     * Return field template
     *
     * @return string
     */
    protected function getFieldTemplate()
    {
        return '../modules/XC/MultiVendor/form_field/vendor/body.twig';
    }

    /**
     * Define widget params
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_HAS_ORDERS => new \XLite\Model\WidgetParam\TypeBool('Has orders', false),
            static::PARAM_ORDERS_URL => new \XLite\Model\WidgetParam\TypeString('Has orders', ''),
        );
    }

    protected function hasOrders()
    {
        return $this->getParam(static::PARAM_HAS_ORDERS);
    }

    protected function getOrdersMessage()
    {
        $url = $this->getParam(static::PARAM_ORDERS_URL);

        return static::t(
            'There are orders with this product. The new vendor will not have access to these orders.',
            array('url' => $url)
        );
    }

    /**
     * Define payment methods
     *
     * @return array
     */
    protected function defineVendorsField()
    {
        $field = $this->getWidget(
            array(
                \XLite\View\FormField\Inline\AInline::PARAM_ENTITY => $this->getProduct(),
                \XLite\View\FormField\Inline\AInline::PARAM_FIELD_NAME => 'vendor',
                \XLite\View\FormField\Inline\AInline::FIELD_NAME => 'vendor',
                \XLite\View\FormField\Inline\AInline::PARAM_FIELD_NAMESPACE => 'vendor',
            ),
            'XLite\Module\XC\MultiVendor\View\FormField\Inline\Select\Vendor'
        );

        return $field;
    }

    protected function displayField()
    {
        $widget = $this->defineVendorsField();

        $widget->display();
    }
}
