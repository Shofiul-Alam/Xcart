<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormField\Select;

use XLite\Core;

/**
 * Product class selector
 */
class ProductClass extends \XLite\View\FormField\Select\ProductClass implements \XLite\Base\IDecorator
{
    /**
     * Get product classes list
     *
     * @return array
     */
    protected function getProductClassesList()
    {
        if (Core\Auth::getInstance()->isVendor()) {
            $list = parent::getProductClassesList();

        } else {
            $list = array();
            $cnd = new Core\CommonCell;

            foreach (Core\Database::getRepo('XLite\Model\ProductClass')->search($cnd) as $pc) {
                if (!$pc->getVendor()) {
                    $list[$pc->getId()] = htmlspecialchars($pc->getName());

                } else {
                    $groupId = 'vendor_' . $pc->getVendor()->getProfileId();

                    if (empty($list[$groupId])) {
                        $list[$groupId] = array(
                            'options' => array($pc->getId() => htmlspecialchars($pc->getName())),
                            'label'   => $this->getVendorsProductClassCaption($pc),
                        );

                    } else {
                        $list[$groupId]['options'][$pc->getId()] = htmlspecialchars($pc->getName());
                    }
                }
            }
        }

        return $list;
    }

    /**
     * Get <optgroup> vendor-specific caption
     *
     * @param \XLite\Model\ProductClass $pc Product class model
     *
     * @return string
     */
    protected function getVendorsProductClassCaption($pc)
    {
        $caption = '';

        if ($pc->getVendor()) {
            $caption = $pc->getVendor()->getVendorCompanyName() . ' (' . $pc->getVendor()->getLogin() . ')';
        }

        return $caption;
    }
}
