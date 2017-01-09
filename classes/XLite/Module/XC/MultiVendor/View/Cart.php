<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View;

/**
 * Cart widget
 */
class Cart extends \XLite\View\Cart implements \XLite\Base\IDecorator
{
    /**
     * Get groups of cart items
     *
     * @return array
     */
    protected function getCartItemsGroups()
    {
        $result = array();

        $groups = parent::getCartItemsGroups();

        $vendors = array();

        foreach ($groups as $group) {
            foreach ($group['items'] as $item) {
                $vendorId = $item->getVendor() ? $item->getVendor()->getProfileId() : null;

                if ($vendorId && !isset($vendors[$vendorId])) {
                    $vendors[$vendorId] = array(
                        'data' => array(
                            'title' => ($item->getVendor()->getVendorCompanyName() ?: static::t('na_vendor')),
                        ),
                        'items' => array(),
                    );
                }

                if ($vendorId) {
                    $vendors[$vendorId]['items'][] = $item;

                } else {
                    $result[0]['items'][] = $item;
                }
            }
        }

        $result = $result + $vendors;

        return $result;
    }
}
