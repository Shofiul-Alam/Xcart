<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Admin;

use XLite\Core;

/**
 * Register vendor page controller
 */
class RegisterVendor extends \XLite\Controller\Admin\AAdmin
{
    /**
     * Return the current page title (for the content area)
     *
     * @return string
     */
    public function getTitle()
    {
        return null;
    }

    /**
     * Everyone can access this page
     *
     * @return integer
     */
    protected function isPublicZone()
    {
        return true;
    }

    /**
     * Class name for the \XLite\View\Model form
     *
     * @return string
     */
    protected function getModelFormClass()
    {
        return 'XLite\Module\XC\MultiVendor\View\Model\Profile\Register';
    }

    /**
     * Preprocessor for no-action run
     *
     * @return void
     */
    protected function doNoAction()
    {
        parent::doNoAction();

        if (Core\Auth::getInstance()->isAdmin()) {
            $this->setReturnURL($this->buildURL());
        }
    }

    /**
     * Create profile action
     *
     * @return void
     */
    protected function doActionRegister()
    {
        $this->getModelForm()->performAction('create');
        $this->postprocessActionRegister();
    }

    /**
     * Postprocess register action
     *
     * @return void
     */
    protected function postprocessActionRegister()
    {
        if (!$this->isActionError()) {
            // Send notification to the user
            Core\Mailer::sendVendorCreatedUserNotification($this->getModelForm()->getModelObject());

            // Send notification to the users department
            Core\Mailer::sendVendorCreatedAdminNotification($this->getModelForm()->getModelObject());

            $this->getModelForm()->getModelObject()->updateBellNotification();

            $this->setReturnURL($this->buildURL('login'));
        }
    }
}
