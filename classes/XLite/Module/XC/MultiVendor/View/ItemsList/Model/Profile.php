<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ItemsList\Model;

/**
 * Profiles items list
 */
class Profile extends \XLite\View\ItemsList\Model\Profile implements \XLite\Base\IDecorator
{
    /**
     * Preprocess access level
     *
     * @param integer              $accessLevel Access level
     * @param array                $column      Column data
     * @param \XLite\Model\Profile $entity      Profile
     *
     * @return string
     */
    protected function preprocessAccessLevel($accessLevel, array $column, \XLite\Model\Profile $entity)
    {
        $result = parent::preprocessAccessLevel($accessLevel, $column, $entity);

        if ($entity->isAdmin() && $entity->isVendor()) {
            $result = static::t('Vendor');
        }

        return $result;
    }
}
