<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Model\Profile;

/**
 * Administrator profile model widget. This widget is used in the admin interface
 */
class AdminMain extends \XLite\View\Model\Profile\AdminMain implements \XLite\Base\IDecorator
{
    /**
     * Return list of the class-specific sections
     *
     * @return array
     */
    protected function getProfileMainSections()
    {
        $result = parent::getProfileMainSections();

        if (\XLite\Core\Auth::getInstance()->isVendor()) {
            $result = array_intersect_key(
                $result,
                array_flip(array(static::SECTION_SUMMARY, static::SECTION_MAIN))
            );
        }

        return $result;
    }

    /**
     * Return true if profile is unapproved vendor
     *
     * @param \XLite\Model\Profile $profile Profile
     *
     * @return boolean
     */
    protected function isUnapprovedVendor($profile)
    {
        return $profile
            && $profile->isVendor()
            && \XLite\Model\Profile::STATUS_UNAPPROVED_VENDOR === $profile->getStatus();
    }


    /**
     * Return fields list by the corresponding schema
     *
     * @return array
     */
    protected function getFormFieldsForSectionAccess()
    {
        if ($this->isUnapprovedVendor($this->getModelObject())) {
            unset($this->accessSchema['status'], $this->accessSchema['statusComment']);
        }

        return parent::getFormFieldsForSectionAccess();
    }

    /**
     * Return class of button panel widget
     *
     * @return string
     */
    protected function getButtonPanelClass()
    {
        return $this->isUnapprovedVendor($this->getModelObject())
            ? 'XLite\Module\XC\MultiVendor\View\StickyPanel\Profile'
            : parent::getButtonPanelClass();
    }

    /**
     * Return list of the "Button" widgets
     *
     * @return array
     */
    protected function getFormButtons()
    {
        $list = parent::getFormButtons();

        if ($this->getModelObject()->isVendor()) {
            $list['transactions'] = $this->getProfileTransactionsButton();
        }

        return $list;
    }

    /**
     * Get "Transactions history" button
     *
     * @return \XLite\View\Button\Link
     */
    protected function getProfileTransactionsButton()
    {
        $url = $this->buildURL(
            'profile_transactions',
            'search',
            array('profile' => $this->getModelObject()->getProfileId())
        );

        return new \XLite\View\Button\Link(
            array(
                \XLite\View\Button\AButton::PARAM_LABEL => 'Transactions history',
                \XLite\View\Button\AButton::PARAM_STYLE => 'action always-enabled',
                \XLite\View\Button\Link::PARAM_LOCATION => $url,
                \XLite\View\Button\Link::PARAM_BLANK    => false,
            )
        );
    }


    /**
     * Populate model object properties by the passed data
     *
     * @param array $data Data to set
     *
     * @return void
     */
    protected function setModelProperties(array $data)
    {
        if (isset($data['access_level'])
            && $data['access_level'] == \XLite\Core\Auth::getInstance()->getVendorAccessLevel()
        ) {
            $data['access_level'] = \XLite\Core\Auth::getInstance()->getAdminAccessLevel();
            $vendorRole = \XLite\Core\Database::getRepo('XLite\Model\Role')->getDefaultVendorRole();
            if ($vendorRole) {
                $data['roles'] = array($vendorRole->getId());
            }
        }

        parent::setModelProperties($data);
    }
}
