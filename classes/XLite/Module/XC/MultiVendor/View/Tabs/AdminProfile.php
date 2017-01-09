<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Tabs;

/**
 * Tabs related to shipping settings
 */
abstract class AdminProfile extends \XLite\View\Tabs\AdminProfile implements \XLite\Base\IDecorator
{
    /**
     * Returns the list of targets where this widget is available
     *
     * @return string[]
     */
    public static function getAllowedTargets()
    {
        $list = parent::getAllowedTargets();
        $list[] = 'vendor';
        $list[] = 'financialInfo';
        $list[] = 'vendor_products';

        return $list;
    }

    /**
     * @return array
     */
    protected function defineTabs()
    {
        $list = parent::defineTabs();
        if (!\XLite\Controller\Admin\Profile::getInstance()->isRegisterMode()
            && $this->getProfile()
            && $this->getProfile()->isVendor()
        ) {
            $list['vendor'] = [
                'weight'   => 300,
                'title'    => static::t('Vendor details'),
                'template' => 'modules/XC/MultiVendor/profile/vendor.twig',
            ];

            $list['financialInfo'] = [
                'weight'   => 310,
                'title'    => static::t('Financial info'),
                'template' => 'modules/XC/MultiVendor/profile/financial.twig',
            ];

            $list['vendor_products'] = [
                'weight'   => 320,
                'title'    => static::t('Vendor products'),
                'template' => 'modules/XC/MultiVendor/profile/products.twig',
            ];
        }

        return $list;
    }
}
