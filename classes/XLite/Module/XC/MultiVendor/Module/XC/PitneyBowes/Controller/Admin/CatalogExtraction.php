<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Module\XC\PitneyBowes\Controller\Admin;

/**
 * CatalogExtraction controller
 * @Decorator\Depend ("XC\PitneyBowes")
 */
class CatalogExtraction extends \XLite\Module\XC\PitneyBowes\Controller\Admin\CatalogExtraction implements \XLite\Base\IDecorator
{
    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        return parent::checkACL()
            || \XLite\Core\Auth::getInstance()->isPermissionAllowed('[vendor] manage shipping');
    }

    /**
     * Upload to PB SFTP Server, called from completed.twig
     *
     * @return boolean
     */
    public function uploadToPB()
    {
        if (\XLite\Core\Auth::getInstance()->isVendor()) {
            $config = \XLite\Module\XC\MultiVendor\Main::getVendorConfiguration(
                \XLite\Core\Auth::getInstance()->getProfile(),
                array('XC', 'PitneyBowes')
            );
            \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::updateConfiguration($config);
        }
        parent::uploadToPB();
    }
}
