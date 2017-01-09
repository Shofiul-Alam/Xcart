<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormField\Select;

use XLite\Core;

/**
 * Attribute groups selector
 */
class AttributeGroups extends \XLite\View\FormField\Select\AttributeGroups implements \XLite\Base\IDecorator
{
    /**
     * Get attribute groups list
     *
     * @return array
     */
    protected function getAttributeGroupsList()
    {
        if (Core\Auth::getInstance()->isVendor()) {
            $list = parent::getAttributeGroupsList();

        } else {
            $list = array();
            $cnd = new Core\CommonCell;
            $cnd->productClass = $this->getProductClass();

            foreach (Core\Database::getRepo('XLite\Model\AttributeGroup')->search($cnd) as $ag) {
                if (!$ag->getVendor()) {
                    $list[$ag->getId()] = htmlspecialchars($ag->getName());

                } else {
                    $groupId = 'vendor_' . $ag->getVendor()->getProfileId();

                    if (empty($list[$groupId])) {
                        $list[$groupId] = array(
                            'options' => array($ag->getId() => htmlspecialchars($ag->getName())),
                            'label'   => $this->getVendorsAttributeGroupCaption($ag),
                        );

                    } else {
                        $list[$groupId]['options'][$ag->getId()] = htmlspecialchars($ag->getName());
                    }
                }
            }
        }

        return $list;
    }

    /**
     * Get <optgroup> vendor-specific caption
     *
     * @param \XLite\Model\AttributeGroup $ag Attribute group object
     *
     * @return string
     */
    protected function getVendorsAttributeGroupCaption($ag)
    {
        return '';
    }
}
