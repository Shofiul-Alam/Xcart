<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Admin;

use XLite\Core;
use XLite\Model;

/**
 * Product
 */
abstract class Product extends \XLite\Controller\Admin\Product implements \XLite\Base\IDecorator
{
    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        return parent::checkACL() || Core\Auth::getInstance()->isPermissionAllowed('[vendor] manage catalog');
    }

    /**
     * Check if current page is accessible
     * todo: add method like isRootAccessAllowed in \XLite\Core\Auth
     *
     * @return boolean
     */
    public function checkAccess()
    {
        return parent::checkAccess()
            && ($this->getProduct()->isOfCurrentVendor()
                || Core\Auth::getInstance()->isPermissionAllowed(Model\Role\Permission::ROOT_ACCESS)
                || Core\Auth::getInstance()->isPermissionAllowed('manage catalog')
            );
    }

    /**
     * Update product class
     *
     * @return void
     */
    protected function doActionUpdateProductClass()
    {
        if ((int) Core\Request::getInstance()->productClass === -1
            && Core\Auth::getInstance()->isVendor()
        ) {
            $name = trim(Core\Request::getInstance()->newProductClass);

            if ($name) {
                $productClass = new Model\ProductClass;
                $productClass->setName($name);
                $productClass->setVendor(Core\Auth::getInstance()->getVendor());

                Core\Database::getRepo('XLite\Model\ProductClass')->insert($productClass);
                Core\Database::getEM()->flush();

                Core\Request::getInstance()->productClass = $productClass->getId();
            }
        }

        parent::doActionUpdateProductClass();
    }
}
