<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\Shofi\AdvanceRegistration\Controller\Customer;

/**
 * Authorization grants are routed to this controller
 */
class SocialLogin extends \XLite\Module\CDev\SocialLogin\Controller\Customer\SocialLogin implements \XLite\Base\IDecorator
{
    

    /**
     * Fetches an existing social login profile or creates new
     *
     * @param string $login          E-mail address
     * @param string $socialProvider SocialLogin auth provider
     * @param string $socialId       SocialLogin provider-unique id
     *
     * @return \XLite\Model\Profile
     */
    protected function getSocialLoginProfile($login, $socialProvider, $socialId)
    {
        $profile = \XLite\Core\Database::getRepo('\XLite\Model\Profile')->findOneBy(
            array(
                'socialLoginProvider'   => $socialProvider,
                'socialLoginId'         => $socialId,
                'order'                 => null,
            )
        );

        if (!$profile) {
            $profile = \XLite\Core\Database::getRepo('XLite\Model\Profile')
                ->findOneBy(array('login' => $login, 'order' => null));

            if (!$profile) {
                $profile = new \XLite\Model\Profile();
                $profile->setLogin($login);
                // Set profile status to 'Unapproved'

                // Set admin access level
                $access_level = \XLite\Core\Auth::getInstance()->getAdminAccessLevel();
                $profile->setAccessLevel($access_level);

                $vendorRole = \XLite\Core\Database::getRepo('XLite\Model\Role')->getDefaultVendorRole();

                // Add new links
                if ($vendorRole) {

                    $profile->addRoles($vendorRole);
                    $vendorRole->addProfiles($profile);
                }
                $profile->create();
            }

        }

        if ($profile) {
            $profile->setSocialLoginProvider($socialProvider);
            $profile->setSocialLoginId($socialId);

        }

        return $profile;
    }



}
