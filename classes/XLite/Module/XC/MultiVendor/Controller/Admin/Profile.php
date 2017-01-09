<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Controller\Admin;

use XLite\Core;
use XLite\Model;

/**
 * Profile page controller
 */
abstract class Profile extends \XLite\Controller\Admin\Profile implements \XLite\Base\IDecorator
{
    /**
     * Flag is true if profile status is changed from Unapproved_vendor to Enabled
     * This flag is used to skip duplicate 'Update profile' notification to a user
     *
     * @var boolean
     */
    protected static $isApprovedStateChanged = false;

    /**
     * Get value of isApprovedStateChanged flag
     *
     * @return boolean
     */
    public static function isApprovedStateChanged()
    {
        $value = static::$isApprovedStateChanged;
        static::$isApprovedStateChanged = false;

        return $value;
    }

    /**
     * Modify profile action
     *
     * @return void
     */
    protected function doActionModify()
    {
        $oldStatus = $this->getModelForm()->getModelObject()->getStatus();

        parent::doActionModify();

        $newStatus = $this->getModelForm()->getModelObject()->getStatus();

        if (Model\Profile::STATUS_UNAPPROVED_VENDOR === $oldStatus
            && $oldStatus !== $newStatus
            && !$this->isActionError()
            && $this->getModelForm()->getModelObject()->isVendor()
        ) {
            static::$isApprovedStateChanged = true;

            $this->sendNotification($this->getModelForm()->getModelObject());
        }
    }

    /**
     * 'Approve vendor' action
     *
     * @return void
     */
    protected function doActionApproveVendor()
    {
        $this->processVendorStatus(Model\Profile::STATUS_ENABLED);
    }

    /**
     * 'Decline vendor' action
     *
     * @return void
     */
    protected function doActionDeclineVendor()
    {
        $this->processVendorStatus(
            Model\Profile::STATUS_DISABLED,
            Core\Request::getInstance()->statusComment
        );
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

            $this->sendNotification($profile);

            if (Model\Profile::STATUS_ENABLED === $newStatus) {
                Core\TopMessage::addInfo(
                    'Vendor account has been successfully approved.'
                );

            } else {
                Core\TopMessage::addInfo(
                    'Vendor account has been declined.'
                );
            }
        }
    }

    /**
     * Send notification
     *
     * @param \XLite\Model\Profile $profile Profile
     *
     * @return void
     */
    protected function sendNotification($profile)
    {
        if (Model\Profile::STATUS_ENABLED === $profile->getStatus()) {
            // Send notification to the user
            Core\Mailer::sendVendorApprovedNotification($profile);

        } elseif (\XLite\Model\Profile::STATUS_DISABLED === $profile->getStatus()) {
            // Send notification to the user
            Core\Mailer::sendVendorDeclinedNotification($profile);
        }
    }
}
