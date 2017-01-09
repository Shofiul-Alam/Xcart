<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormModel\Product;

use XLite\Core;
use XLite\Model\Repo;

class Info extends \XLite\View\FormModel\Product\Info implements \XLite\Base\IDecorator
{
    /**
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'modules/XC/MultiVendor/form_model/product/info/controller.js';

        return $list;
    }

    /**
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/XC/MultiVendor/form_model/product/info/style.css';

        return $list;
    }

    /**
     * @return array
     */
    protected function defineFields()
    {
        $schema = parent::defineFields();

        if (Core\Auth::getInstance()->hasRootAccess()) {
            $vendors = [(string) Repo\Profile::ADMIN_VENDOR_FAKE_ID => static::t('Administrator')];
            foreach (Core\Database::getRepo('XLite\Model\Profile')->findAllVendors() as $profile) {
                $vendors[(string) $profile->getProfileId()]
                    = $profile->getVendorCompanyName() . ' (' . $profile->getLogin() . ')';
            }

            $vendorDescription = $this->getDataObject()->default->identity ? $this->getWidget([
                'template' => 'modules/XC/MultiVendor/form_model/product/info/vendor_description.twig',
            ])->getContent() : '';

            $schema[self::SECTION_DEFAULT]['vendor'] = [
                'label'             => static::t('Vendor'),
                'description'       => $vendorDescription,
                'type'              => 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',
                'choices'           => array_flip($vendors),
                'choices_as_values' => true,
                'placeholder'       => false,
                'position'          => 50,
            ];
        }

        return $schema;
    }

    /**
     * Check if current product vendor has orders
     *
     * @return boolean
     */
    protected function hasOrders()
    {
        $product = Core\Database::getRepo('XLite\Model\Product')->find($this->getDataObject()->default->identity);

        return $product->isPersistent() && $product->getOrdersCount();
    }

    /**
     * Returns orders search result for current vendor
     *
     * @return string
     */
    protected function getOrdersMessage()
    {
        $product = Core\Database::getRepo('XLite\Model\Product')->find($this->getDataObject()->default->identity);

        $vendorId = Repo\Profile::ADMIN_VENDOR_FAKE_ID;
        $vendor = static::t('Administrator');

        if ($product->getVendor()) {
            $profile = $product->getVendor();
            $vendorId = $profile->getProfileId();
            $vendor = $profile->getVendorCompanyName() . ' (' . $profile->getLogin() . ')';
        }

        $url = $this->buildURL('order_list', 'search', [
            'vendorId' => $vendorId,
            'vendor'   => $vendor,
            'sku'      => $product->getSku(),
        ]);

        return static::t(
            'There are orders with this product. The new vendor will not have access to these orders.',
            ['url' => $url]
        );
    }

    /**
     * Return form theme files. Used in template.
     *
     * @return array
     */
    protected function getFormThemeFiles()
    {
        $list = parent::getFormThemeFiles();

        if ($this->getDataObject()->default->identity) {
            $list[] = 'modules/XC/MultiVendor/form_model/product/info/theme.twig';
        }

        return $list;
    }
}
