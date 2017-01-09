<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\StickyPanel;

/**
 * Profile management form sticky panel
 */
class Profile extends \XLite\View\StickyPanel\ItemForm
{
    /**
     * Get list of JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'modules/XC/MultiVendor/sticky_panel/profile/controller.js';

        return $list;
    }

    /**
     * Get list of CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'modules/XC/MultiVendor/sticky_panel/profile/style.css';

        return $list;
    }

    /**
     * Define buttons widgets
     *
     * @return array
     */
    protected function defineButtons()
    {
        $list = parent::defineButtons();

        if ($this->isProfileAllowedToApprove()) {
            $list['approve'] = $this->getApproveButton();
            $list['decline'] = $this->getDeclineButton();
        }

        return $list;
    }

    /**
     * Return true if profile meets conditions
     *
     * @return boolean
     */
    protected function isProfileAllowedToApprove()
    {
        return \XLite\Core\Auth::getInstance()->getProfile()
            && \XLite\Core\Auth::getInstance()->isAdmin()
            && (\XLite\Core\Auth::getInstance()->isPermissionAllowed('manage admins')
                || \XLite\Core\Auth::getInstance()->isPermissionAllowed(\XLite\Model\Role\Permission::ROOT_ACCESS));
    }

    /**
     * Get approve button
     *
     * @return \XLite\View\Button\Regular
     */
    protected function getApproveButton()
    {
        return $this->getWidget(
            array(
                'style'    => 'action approve always-enabled',
                'label'    => $this->getApproveButtonLabel(),
                'disabled' => false,
                \XLite\View\Button\AButton::PARAM_BTN_TYPE => 'regular-main-button',
                \XLite\View\Button\Regular::PARAM_ACTION => 'approveVendor',
            ),
            'XLite\View\Button\Regular'
        );
    }

    /**
     * Defines the label for the approve button
     *
     * @return string
     */
    protected function getApproveButtonLabel()
    {
        return static::t('Approve vendor');
    }

    /**
     * Get decline button
     *
     * @return \XLite\View\Button\Regular
     */
    protected function getDeclineButton()
    {
        return $this->getWidget(
            array(
                'template' => 'modules/XC/MultiVendor/sticky_panel/profile/parts/decline.twig',
            )
        );
    }
}
