<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */


namespace XLite\Module\XC\MultiVendor\View\Pager;

/**
 * Decorated APager
 */
abstract class APager extends \XLite\View\Pager\APager implements \XLite\Base\IDecorator
{
    /**
     * isSearchTotalVisible
     *
     * @return boolean
     */
    protected function isSearchTotalVisible()
    {
        return parent::isSearchTotalVisible()
            || 'profile_transactions' == \XLite\Core\Request::getInstance()->target;
    }

    /**
     * isVisible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible() || $this->isSearchTotalVisible();
    }
}