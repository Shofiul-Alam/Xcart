<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormField\Input;

use XLite\Core;

/**
 * Attribute option field widget extension
 */
class AttributeOption extends \XLite\View\FormField\Input\Text\AttributeOption implements \XLite\Base\IDecorator
{
    /**
     * Prepare attributes
     *
     * @param array $attrs Field attributes to prepare
     *
     * @return array
     */
    protected function prepareAttributes(array $attrs)
    {
        if (!$this->isNewOptionValueAllowed()) {
            $attrs['readonly'] = 'readonly';
        }

        return parent::prepareAttributes($attrs);
    }

    /**
     * Return true if attribute option can be created
     *
     * @return boolean
     */
    protected function isNewOptionValueAllowed()
    {
        $attr = $this->getParam(self::PARAM_ATTRIBUTE);

        $auth = Core\Auth::getInstance()->isVendor();

        return !$auth
            || (
                $attr
                && (
                    'A' === Core\Config::getInstance()->XC->MultiVendor->attributes_access_mode
                    || Core\Auth::getInstance()->checkVendorAccess($attr->getVendor())
                )
            );
    }
}
