<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 7/01/2017
 * Time: 2:08 PM
 */

namespace XLite\Module\Shofi\AdvanceRegistration\View\Model\Profile;


class Register extends \XLite\Module\XC\MultiVendor\View\Model\Profile\Register implements \XLite\Base\IDecorator
{
    /**
     * Populate model object properties by the passed data
     *
     * @param array $data Data to set
     *
     * @return void
     */
    protected function setModelProperties(array $data)
    {
        xdebug_break();
        if($this->isRegisterMode()) {
            xdebug_break();
            parent::setModelProperties($data);

        } else {
            xdebug_break();
            \XLite\View\Model\Profile\Main::setModelProperties($data);
        }
    }

    /**
     * Add top message on successful profile creation
     *
     * @return void
     */
    protected function addDataSavedTopMessage()
    {
        if($this->isRegisterMode()) {
            \XLite\Core\TopMessage::addInfo(
                'Thank you for registered a vendor account. After administrator approval you will be able to login and start to sell.'
            );
        } else {
            \XLite\Core\TopMessage::addInfo(
                'Your Profile is sucessfully updated.'
            );
        }

    }
}