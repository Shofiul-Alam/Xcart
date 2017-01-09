<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Admin;

use XLite\Core;
use XLite\Model\Repo;

/**
 * Autocomplete controller
 */
abstract class Autocomplete extends \XLite\Controller\Admin\Autocomplete implements \XLite\Base\IDecorator
{
    /**
     * VENDORS_MAX_RESULTS
     */
    const VENDORS_MAX_RESULTS = 9;

    /**
     * Get list of possible dictionary permissions
     *
     * @return array
     */
    protected function getDictionaryPermissions()
    {
        $list = parent::getDictionaryPermissions();
        $list['vendors'] = array('manage catalog');
        $list['attributeOption'] = array_merge($list['attributeOption'], array('[vendor] manage catalog'));
        $list['profiles'] = array_merge($list['profiles'], array('[vendor] manage orders'));

        return $list;
    }

    /**
     * Assemble dictionary - conversation recipient
     *
     * @param string $term Term
     *
     * @return array
     */
    protected function assembleDictionaryVendors($term)
    {
        $profiles = Core\Database::getRepo('XLite\Model\Profile')
            ->findVendorsByTerm($term, static::VENDORS_MAX_RESULTS);

        return $this->packVendorData($profiles);
    }

    /**
     * Get certain data from profile array for new array
     *
     * @param array $profiles Array of profiles
     *
     * @return array
     */
    protected function packVendorData(array $profiles)
    {
        $result = array();

        $result[Repo\Profile::ADMIN_VENDOR_FAKE_ID] = array(
            'name' => static::t('Administrator'),
        );

        foreach ($profiles as $k => $profile) {
            $result[$profile->getProfileId()] = array(
                'name' => $profile->getVendorCompanyName() . ' (' . $profile->getLogin() . ')',
            );
        }

        return $result;
    }

    /**
     * Get certain data from profile array for new array
     *
     * @param array $profiles Array of profiles
     *
     * @return array
     */
    protected function packProfilesData(array $profiles)
    {
        $result = parent::packProfilesData($profiles);

        if (Core\Auth::getInstance()->isVendor() && Core\Config::getInstance()->XC->MultiVendor->mask_contacts) {
            // Mask contacts
            foreach ($result as $k => $v) {
                $result[$k] = preg_replace('/^(.+)\([^\(]+@[^\)]+\)$/USs', '\\1', $v);
            }
        }

        return $result;
    }
}
