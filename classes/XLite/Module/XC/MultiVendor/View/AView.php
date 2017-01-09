<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View;

use XLite\Core\Auth;

/**
 * Abstract widget
 */
abstract class AView extends \XLite\View\AView implements \XLite\Base\IDecorator
{
    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        if (\XLite::isAdminZone() && Auth::getInstance()->isVendor()) {
            $list[] = 'modules/XC/MultiVendor/css/vendor_style.css';
        }

        if (!\XLite::isAdminZone()) {
            $list[] = array(
                'file'  => 'modules/XC/MultiVendor/product/vendor_info/style.less',
                'media' => 'screen',
                'merge' => 'bootstrap/css/bootstrap.less',
            );
        }

        return $list;
    }

    /**
     * Return specific data for address entry. Helper.
     *
     * @param \XLite\Model\Address $address   Address
     * @param boolean              $showEmpty Show empty fields OPTIONAL
     *
     * @return array
     */
    protected function getAddressSectionData(\XLite\Model\Address $address, $showEmpty = false)
    {
        $data = parent::getAddressSectionData($address, $showEmpty);

        if (
            is_array($data)
            && $address
            && array_intersect(array_keys($data), $this->getUnallowedProfileFields())
            && \XLite\Core\Auth::getInstance()->isVendor()
            && \XLite\Core\Config::getInstance()->XC->MultiVendor->mask_contacts
            && $address->getProfile()->getLogin() != \XLite\Core\Auth::getInstance()->getProfile()->getLogin()
        ) {
            // Remove unallowed fields
            foreach ($this->getUnallowedProfileFields() as $f) {
                if (isset($data[$f])) {
                    unset($data[$f]);
                }
            }
        }

        return $data;
    }

    /**
     * Get list of profile fields which should not be displayed by widget
     *
     * @return array
     */
    protected function getUnallowedProfileFields()
    {
        return array('phone', 'vat_number');
    }
}
