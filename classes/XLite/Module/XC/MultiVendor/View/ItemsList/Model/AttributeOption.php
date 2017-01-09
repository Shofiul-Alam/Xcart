<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ItemsList\Model;

use XLite\Core;

/**
 * Attribute options items list
 */
class AttributeOption extends \XLite\View\ItemsList\Model\AttributeOption implements \XLite\Base\IDecorator
{
    /**
     * Flag: ignore static mode if true
     *
     * @var boolean
     */
    protected $ignoreStatic = false;

    /**
     * Return true if current attribute was not created by current vendor
     *
     * @return boolean
     */
    protected function isStatic()
    {
        $result = parent::isStatic();

        if (!$result && !$this->ignoreStatic) {
            $attribute = $this->getAttribute();

            $result = $attribute && !Core\Auth::getInstance()->checkVendorAccess($attribute->getVendor());
        }

        $this->ignoreStatic = false;

        return $result;
    }

    /**
     * Get top actions
     *
     * @return array
     */
    protected function getTopActions()
    {
        // Ignore static mode if user can add new option values
        $this->ignoreStatic = $this->isNewOptionsAllowed();

        return parent::getTopActions();
    }

    /**
     * Get bottom actions
     *
     * @return array
     */
    protected function getBottomActions()
    {
        // Ignore static mode if user can add new option values
        $this->ignoreStatic = $this->isNewOptionsAllowed();

        return parent::getBottomActions();
    }

    /**
     * Return true if user can add new option values
     *
     * @return boolean
     */
    protected function isNewOptionsAllowed()
    {
        return 'A'=== Core\Config::getInstance()->XC->MultiVendor->attributes_access_mode;
    }
}
