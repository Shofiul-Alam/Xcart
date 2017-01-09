<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Admin;

/**
 * VendorProducts controller
 */
class VendorProducts extends \XLite\Controller\Admin\AAdmin
{
    /**
     * Controller parameters
     *
     * @var array
     */
    protected $params = array('profile_id');
    
    /**
     * Get itemsList class
     *
     * @return string
     */
    public function getItemsListClass()
    {
        return parent::getItemsListClass() ?: 'XLite\Module\XC\MultiVendor\View\ItemsList\Model\VendorProducts';
    }

    /**
     * Do action search
     *
     * @return void
     */
    protected function doActionSearch()
    {
        parent::doActionSearchItemsList();
    }

    /**
     * Do action search
     *
     * @return void
     */
    protected function doActionSearchItemsList()
    {
        parent::doActionSearchItemsList();

        $this->setReturnURL($this->getURL(array('mode' => 'search', 'searched' => 1)));
    }

    /**
     * Return search parameters for product list.
     * It is based on search params from Product Items list viewer
     *
     * @return array
     */
    protected function getSearchParams()
    {
        return parent::getSearchParams()
        + $this->getSearchParamsCheckboxes();
    }

    /**
     * Return search parameters for product list given as checkboxes: (0, 1) values
     *
     * @return array
     */
    protected function getSearchParamsCheckboxes()
    {
        $productsSearchParams = array();

        $itemsListClass = $this->getItemsListClass();
        $cBoxFields = array(
            $itemsListClass::PARAM_SEARCH_IN_SUBCATS,
            $itemsListClass::PARAM_BY_TITLE,
            $itemsListClass::PARAM_BY_DESCR,
        );

        foreach ($cBoxFields as $requestParam) {
            $productsSearchParams[$requestParam] = isset(\XLite\Core\Request::getInstance()->$requestParam) ? 1 : 0;
        }

        return $productsSearchParams;
    }

    /**
     * Return the current page title (for the content area)
     *
     * @return string
     */
    public function getTitle()
    {
        return static::t('Vendor products');
    }

    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        $profile = $this->getProfile();

        return parent::checkACL()
        || \XLite\Core\Auth::getInstance()->isPermissionAllowed('manage users')
        || ($profile && $profile->getProfileId() === \XLite\Core\Auth::getInstance()->getProfile()->getProfileId());
    }

    /**
     * Check if current page is accessible
     *
     * @return boolean
     */
    public function checkAccess()
    {
        $profile = $this->getProfile();

        return parent::checkAccess() && $profile && $profile->isVendor() && $this->isOrigProfile();
    }

    /**
     * The "mode" parameter used to determine if we create new or modify existing profile
     *
     * @return boolean
     */
    public function isRegisterMode()
    {
        return false;
    }

    /**
     * Check controller visibility
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible() && $this->getModelForm()->getModelObject();
    }

    /**
     * Alias
     *
     * @return \XLite\Model\Profile
     */
    protected function getProfile()
    {
        return $this->getModelForm()->getModelObject();
    }

    /**
     * Alias
     *
     * @return \XLite\Model\Profile
     */
    public function getProfileId()
    {
        return $this->getProfile()->getProfileId();
    }
    
    /**
     * Return true if profile is not related with any order (i.e. it's an original profile)
     *
     * @return boolean
     */
    protected function isOrigProfile()
    {
        return !($this->getProfile() && $this->getProfile()->getOrder());
    }

    /**
     * Class name for the \XLite\View\Model\ form
     *
     * @return string
     */
    protected function getModelFormClass()
    {
        return 'XLite\Module\XC\MultiVendor\View\Model\Profile\VendorProducts';
    }
}