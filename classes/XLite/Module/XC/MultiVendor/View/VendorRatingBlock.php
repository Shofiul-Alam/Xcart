<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View;

/**
 * Vendor rating block
 *
 * @ListChild (list="sidebar.first.vendor_info", zone="customer", weight="40")
 */
class VendorRatingBlock extends \XLite\View\AView
{
    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'modules/XC/MultiVendor/vendor_rating/style.less';

        return $list;
    }

    /**
     * Return list of targets allowed for this widget
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $result = parent::getAllowedTargets();
        $result[] = 'vendor';

        return $result;
    }

    /**
     * Get all registered vendors
     *
     * @return \XLite\Model\Profile
     */
    protected function getVendor()
    {
        $id = \XLite\Core\Request::getInstance()->vendor_id;

        return \XLite\Core\Database::getRepo('XLite\Model\Profile')->find($id);
    }

    /**
     * Get widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/XC/MultiVendor/vendor_rating/body.twig';
    }

    /**
     * Register the CSS classes for this block
     *
     * @return string
     */
    protected function getBlockClasses()
    {
        return parent::getBlockClasses() . ' block-vendor-rating';
    }

    /**
     * Is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible()
            && \XLite\Core\Config::getInstance()->XC->MultiVendor->enable_vendor_rating
            && $this->getVendor()
            && $this->getRatingsProvider()
            && $this->getVotesCount() > 0;
    }

    /**
     * Get ratings provider
     *
     * @return \XLite\Module\XC\MultiVendor\Core\IRatingsProvider|null
     */
    protected function getRatingsProvider()
    {
        return \XLite\Module\XC\MultiVendor\Core\VendorRatingProvider::getInstance()->getProvider();
    }

    /**
     * Get maximum rating value
     *
     * @return integer
     */
    public function getMaxRatingValue()
    {
        return $this->getRatingsProvider()->getMaxRatingValue();
    }

    /**
     * Get reviews count
     *
     * @return integer
     */
    public function getVotesCount()
    {
        return $this->getRatingsProvider()->getOverallCount($this->getVendor());
    }

    /**
     * Get overall rating
     *
     * @return integer
     */
    public function getOverallRating()
    {
        $value = $this->getRatingsProvider()->getOverallRating($this->getVendor());

        return $this->formatNumber($value, 2);
    }

    /**
     * Format number
     *
     * @param float     $value      Value
     * @param integer   $decimals   Number of decimal points    OPTIONAL
     *
     * @return string
     */
    public function formatNumber($value, $decimals = 0)
    {
        return number_format($value, $decimals, ',', ' ');
    }

    /**
     * Get ratings data
     *
     * @return array
     */
    public function getRatings()
    {
        return $this->getRatingsProvider()->getData($this->getVendor());
    }
}
