<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\Shofi\AdvanceRegistration\Controller\Customer;

use XLite\Model;
use XLite\Core;
/**
 * User profile page controller
 */
class Profile extends \XLite\Controller\Customer\Profile implements \XLite\Base\IDecorator
{

    protected $address = null;
    protected $result = null;
    /**
     * Types of model form
     */
    const SECTIONS_MAIN      = 'main';
    const SECTIONS_ADDRESSES = 'addresses';
    const SECTIONS_ALL       = 'all';

    /**
     * Return value for the "register" mode param
     *
     * @return string
     */
    public static function getRegisterMode()
    {
        return 'register';
    }

    /**
     * handleRequest
     *
     * @return void
     */
    public function handleRequest()
    {
        xdebug_break();
        if (!$this->isLogged() && !$this->isRegisterMode()) {
            $this->setReturnURL($this->buildURL('login'));
        }

        parent::handleRequest();
    }

    /**
     * Set if the form id is needed to make an actions
     * Form class uses this method to check if the form id should be added
     *
     * @return boolean
     */
    public static function needFormId()
    {
        return true;
    }

    /**
     * Check - controller must work in secure zone or not
     *
     * @return boolean
     */
    public function isSecure()
    {
        xdebug_break();
        return \XLite\Core\Config::getInstance()->Security->customer_security;
    }

    /**
     * Returns title of the page
     *
     * @return string
     */
    public function getTitle()
    {
        if ($this->isRegisterMode()) {
            $title = static::t('New account');

        } elseif ('delete' == \XLite\Core\Request::getInstance()->mode) {
            $title = static::t('Delete account');

        } else {
            $title = static::t('Account details');
        }

        return $title;
    }

    /**
     * Check whether the title is to be displayed in the content area
     *
     * @return boolean
     */
    public function isTitleVisible()
    {
        return 'delete' == \XLite\Core\Request::getInstance()->mode;
    }

    /**
     * The "mode" parameter used to determine if we create new or modify existing profile
     *
     * @return boolean
     */
    public function isRegisterMode()
    {
        return self::getRegisterMode() === \XLite\Core\Request::getInstance()->mode
            || !$this->getModelForm()->getModelObject()->isPersistent();
    }

    /**
     * Check if current page is accessible
     *
     * @return boolean
     */
    protected function checkAccess()
    {
        return parent::checkAccess() && $this->checkProfile();
    }

    /**
     * Define current location for breadcrumbs
     *
     * @return string
     */
    protected function getLocation()
    {
        return $this->getTitle();
    }

    /**
     * Add part to the location nodes list
     *
     * @return void
     */
    protected function addBaseLocation()
    {
        parent::addBaseLocation();

        if (!$this->isRegisterMode()) {
            $this->addLocationNode(static::t('My account'));
        }
    }

    /**
     * Return class name of the register form
     *
     * @return string|void
     */
    protected function getModelFormClass()
    {
        return 'XLite\Module\XC\MultiVendor\View\Model\Profile\Register';
    }

    /**
     * Check if profile is not exists
     *
     * @return boolean
     */
    protected function doActionValidate()
    {
        return $this->getModelForm()->performAction('validateInput');
    }

    /**
     * doActionRegister
     *
     * @return boolean
     */
    protected function doActionRegister()
    {
        xdebug_break();
        $this->getModelForm()->getModelObject()->setStatus(Model\Profile::STATUS_ENABLED);
        xdebug_break();
        $this->result = $this->getModelForm()->performAction('create');
        $this->postprocessActionRegister();

        xdebug_break();
        return $this->result;
    }
    /**
     * 'Approve vendor' action
     *
     * @return void
     */
    protected function approveVendor()
    {
        $this->processVendorStatus(Model\Profile::STATUS_ENABLED);
    }


    /**
     * Process vendor status change
     *
     * @param integer $newStatus     New profile status value
     * @param string  $statusComment Status comment
     *
     * @return void
     */
    protected function processVendorStatus($newStatus, $statusComment = null)
    {
        $profile = $this->getModelForm()->getModelObject();

        $oldStatus = $profile->getStatus();

        if (Model\Profile::STATUS_UNAPPROVED_VENDOR === $oldStatus && $profile->isVendor()) {
            $profile->setStatus($newStatus);

            if ($statusComment) {
                $profile->setStatusComment($statusComment);
            }

            $profile->update();


        }
    }


    /**
     * Postprocess register action
     *
     * @return void
     */
    protected function postprocessActionRegister()
    {
        if ($this->isActionError()) {
            $this->postprocessActionRegisterFail();
            $this->setReturnURL(
                call_user_func_array(array($this, 'buildURL'), $this->getActionRegisterFailURL())
            );


        } else {
            $this->postprocessActionRegisterSuccess();
            $this->setReturnURL(
                call_user_func_array(array($this, 'buildURL'), $this->getActionRegisterSuccessURL())
            );
        }
    }

    /**
     * Postprocess register action (fail)
     *
     * @return array
     */
    protected function postprocessActionRegisterFail()
    {
    }

    /**
     * Get register fail URL arguments
     *
     * @return array
     */
    protected function getActionRegisterFailURL()
    {
        return array(
            'profile',
            '',
            array('mode' => static::getRegisterMode())
        );
    }

    /**
     * Postprocess register action (success)
     *
     * @return array
     */
    protected function postprocessActionRegisterSuccess()
    {


        xdebug_break();
        // Send notification
        \XLite\Core\Mailer::sendProfileCreated($this->getModelForm()->getModelObject());



        $this->getCart()->login($this->getModelForm()->getModelObject());



        // Log in user with created profile
        \XLite\Core\Auth::getInstance()->loginProfile($this->getModelForm()->getModelObject());
        xdebug_break();
        $this->setHardRedirect();

        xdebug_break();
        if (!$this->isLogged()) {
        xdebug_break();
            $addressBook = new \XLite\Controller\Customer\AddressBook();
            //$addressView = new \XLite\View\Model\Address\Address();
            xdebug_break();
            $this->address = $addressBook->getModelForm()->getModelObject();
            xdebug_break();
            $this->address->setProfile($this->getModelForm()->getModelObject());
            xdebug_break();
            $addressBook->getModelForm()->performAction('update');
            $this->approveVendor();
            $this->setHardRedirect();

        }

    }



}
