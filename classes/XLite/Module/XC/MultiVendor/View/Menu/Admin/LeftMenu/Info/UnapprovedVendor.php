<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Menu\Admin\LeftMenu\Info;

/**
 * Node lazy load abstract class
 */
class UnapprovedVendor extends \XLite\View\Menu\Admin\LeftMenu\ANodeNotification
{
    /**
     * Check if data is updated (must be fast)
     *
     * @return boolean
     */
    public function isUpdated()
    {
        return $this->getLastReadTimestamp() < $this->getLastUpdateTimestamp();
    }

    /**
     * Get cache parameters
     *
     * @return array
     */
    public function getCacheParameters()
    {
        return array(
            'unapprovedVendorUpdateTimestamp' => $this->getLastUpdateTimestamp(),
        );
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible() && $this->getCounter();
    }

    /**
     * Return update timestamp
     *
     * @return integer
     */
    protected function getLastUpdateTimestamp()
    {
        $result = \XLite\Core\TmpVars::getInstance()->unapprovedVendorUpdateTimestamp;

        if (null === $result) {
            $result = LC_START_TIME;
            \XLite\Core\TmpVars::getInstance()->unapprovedVendorUpdateTimestamp = $result;
        }

        return $result;
    }

    // {{{ View helpers

    /**
     * Returns node style class
     *
     * @return array
     */
    protected function getNodeStyleClasses()
    {
        $list = parent::getNodeStyleClasses();
        $list[] = 'info';

        return $list;
    }

    /**
     * Returns icon
     *
     * @return string
     */
    protected function getIcon()
    {
        return $this->getSVGImage('images/info.svg');
    }

    /**
     * Returns header url
     *
     * @return string
     */
    protected function getHeaderUrl()
    {
        return $this->buildURL(
            'profile_list',
            'search',
            array(
                 \XLite\Model\Repo\Profile::SEARCH_STATUS => \XLite\Model\Profile::STATUS_UNAPPROVED_VENDOR,
            )
        );
    }

    /**
     * Returns header
     *
     * @return string
     */
    protected function getHeader()
    {
        return static::t('Unapproved vendors');
    }

    /**
     * Get entries count
     *
     * @return integer
     */
    protected function getCounter()
    {
        return \XLite\Core\Database::getRepo('XLite\Model\Profile')->getUnapprovedVendorsAmount();
    }

    // }}}
}
