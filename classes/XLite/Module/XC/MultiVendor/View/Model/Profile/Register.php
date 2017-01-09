<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Model\Profile;

use XLite\Module\XC\MultiVendor;

/**
 * Vendor profile register page widget
 *
 * @ListChild (list="admin.center", weight="0", zone="admin")
 */
class Register extends \XLite\View\Model\Profile\Main
{
    /**
     * Returns the list of targets where this widget is available
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $list = parent::getAllowedTargets();
        $list[] = 'register_vendor';

        return $list;
    }

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'unauthorized/style.less';
        $list[] = 'modules/XC/MultiVendor/css/register_vendor.css';

        return $list;
    }

    /**
     * Hide page subheader (only title defined in controller will be displayed)
     *
     * @return string
     */
    protected function getHead()
    {
        return null;
    }

    /**
     * Correct header of main section
     *
     * @return array
     */
    protected function getProfileMainSections()
    {
        $list = parent::getProfileMainSections();
        $list[self::SECTION_MAIN] = 'Register vendor profile';

        return $list;
    }

    /**
     * Return name of web form widget class
     *
     * @return string
     */
    protected function getFormClass()
    {
        return 'XLite\Module\XC\MultiVendor\View\Form\Profile\Register';
    }

    /**
     * Flag if the panel widget for buttons is used
     *
     * @return boolean
     */
    protected function useButtonPanel()
    {
        return false;
    }

    /**
     * Return fields list by the corresponding schema
     *
     * @return array
     */
    protected function getFormFieldsForSectionMain()
    {
        if (isset($this->mainSchema['membership_id'])) {
            unset($this->mainSchema['membership_id']);
        }

        if (isset($this->mainSchema['pending_membership_id'])) {
            unset($this->mainSchema['pending_membership_id']);
        }

        return parent::getFormFieldsForSectionMain();
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
        // Set profile status to 'Unapproved'
        $data['status'] = \XLite\Model\Profile::STATUS_UNAPPROVED_VENDOR;

        // Set admin access level
        $data['access_level'] = \XLite\Core\Auth::getInstance()->getAdminAccessLevel();

        $vendorRole = \XLite\Core\Database::getRepo('XLite\Model\Role')->getDefaultVendorRole();

        // Add new links
        if ($vendorRole) {
            $model = $this->getModelObject();
            $model->addRoles($vendorRole);
            $vendorRole->addProfiles($model);
        }

        parent::setModelProperties($data);
    }

    /**
     * Add top message on successful profile creation
     *
     * @return void
     */
    protected function addDataSavedTopMessage()
    {
        \XLite\Core\TopMessage::addInfo(
            'Thank you for registered a vendor account. After administrator approval you will be able to login and start to sell.'
        );
    }
}
