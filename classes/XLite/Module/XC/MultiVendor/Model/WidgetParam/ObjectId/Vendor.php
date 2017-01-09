<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\WidgetParam\ObjectId;

/**
 * Vendor object id representation
 */
class Vendor extends \XLite\Model\WidgetParam\TypeObjectId
{
    /**
     * Return object class name
     *
     * @return string
     */
    protected function getClassName()
    {
        return 'XLite\Model\Profile';
    }

    /**
     * getObjectExistsCondition
     *
     * @param mixed $value Value to check
     *
     * @return array
     */
    protected function getObjectExistsCondition($value)
    {
        $result = parent::getIdValidCondition($value);

        $result[self::ATTR_CONDITION] = $result[self::ATTR_CONDITION] && $value > 0;

        return $result;
    }
}
