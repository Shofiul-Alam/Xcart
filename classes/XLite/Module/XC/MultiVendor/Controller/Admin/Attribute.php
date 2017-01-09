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
 * Attribute controller
 */
abstract class Attribute extends \XLite\Controller\Admin\Attribute implements \XLite\Base\IDecorator
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
     * Return the current page title (for the content area)
     *
     * @return string
     */
    public function getTitle()
    {
        $id = (int) Core\Request::getInstance()->id;

        $model = $id
            ? Core\Database::getRepo('XLite\Model\Attribute')->find($id)
            : null;

        if ($model
            && Model\Attribute::TYPE_SELECT === $model->getType()
            && Core\Auth::getInstance()->isVendor()
            && !Core\Auth::getInstance()->checkVendorAccess($model->getVendor())
        ) {
            $result = 'A' === Core\Config::getInstance()->XC->MultiVendor->attributes_access_mode
                ? static::t('Edit attribute values')
                : static::t('View attribute values');

        } else {
            $result = parent::getTitle();
        }

        return $result;
    }

    /**
     * Update model
     *
     * @return void
     */
    protected function doActionUpdate()
    {
        $attribute = $this->getModelForm()->getModelObject();

        $assignVendor = !$attribute->getId();

        parent::doActionUpdate();

        if ($assignVendor && Core\Auth::getInstance()->isVendor()) {
            $attribute->setVendor(Core\Auth::getInstance()->getVendor());

            Core\Database::getEM()->flush();
        }
    }
}
