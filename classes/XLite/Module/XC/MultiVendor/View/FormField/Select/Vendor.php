<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\FormField\Select;

use XLite\Core;
use XLite\Model\Repo;

/**
 * Vendor profiles select
 */
class Vendor extends \XLite\View\FormField\Select\Profile\AProfile
{
    /**
     * Return default options list
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        $list = array(Repo\Profile::ADMIN_VENDOR_FAKE_ID => static::t('Administrator'));

        foreach (Core\Database::getRepo('XLite\Model\Profile')->findAllVendors() as $profile) {
            $list[$profile->getProfileId()] = $profile->getVendorCompanyName() . ' (' . $profile->getLogin() . ')';
        }

        return $list;
    }
}
