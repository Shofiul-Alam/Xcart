<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ItemsList\Model;

/**
 * ProfileTransactions statistics items list
 */
class ProfileTransactionsStats extends \XLite\View\ItemsList\Model\Table
{
    /**
     * Widget param names
     */
    const PARAM_PROFILE = 'profile';

    /**
     * Sort modes
     *
     * @var   array
     */
    protected $sortByModes = array(
        'p.login'           => 'Login',
        'debit_total'       => 'Debit',
        'credit_total'      => 'Credit',
        'balance'           => 'Balance',
    );

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        return array(
            'profile' => array(
                static::COLUMN_NAME     => static::t('Vendor'),
                static::COLUMN_TEMPLATE => 'modules/XC/MultiVendor/profile.twig',
                static::COLUMN_NO_WRAP  => true,
                static::COLUMN_MAIN     => true,
                static::COLUMN_SORT => 'p.login',
            ),
            'history_link' => array(
                static::COLUMN_NAME => static::t('Transactions history'),
                static::COLUMN_TEMPLATE => 'modules/XC/MultiVendor/profile_transactions/cell.history_link.twig',
            ),
            'debit_total' => array(
                static::COLUMN_NAME => static::t('Income'),
                static::COLUMN_SORT => 'debit_total',
            ),
            'credit_total' => array(
                static::COLUMN_NAME => static::t('Expense'),
                static::COLUMN_SORT => 'credit_total',
            ),
            'balance' => array(
                static::COLUMN_NAME => static::t('Liability'),
                static::COLUMN_SORT => 'balance',
            ),
        );
    }

    /**
     * Return search parameters
     *
     * @return array
     */
    public static function getSearchParams()
    {
        $params = array(
            \XLite\Model\Repo\Profile::SEARCH_LOGIN  => static::PARAM_PROFILE,
        );

        return $params;
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_PROFILE => new \XLite\Model\WidgetParam\TypeString('Vendor', ''),
        );
    }
    
    /**
     * Define so called "request" parameters
     *
     * @return void
     */
    protected function defineRequestParams()
    {
        parent::defineRequestParams();

        $this->requestParams = array_merge($this->requestParams, static::getSearchParams());
    }

    /**
     * Return entities list
     *
     * @param \XLite\Core\CommonCell $cnd       Search condition
     * @param boolean                $countOnly Return items list or only its size OPTIONAL
     *
     * @return array|integer
     */
    protected function getData(\XLite\Core\CommonCell $cnd, $countOnly = false)
    {
        foreach (static::getSearchParams() as $modelParam => $requestParam) {
            $value = is_string($this->getParam($requestParam))
                ? trim($this->getParam($requestParam))
                : $this->getParam($requestParam);

            $cnd->$modelParam = $value;
        }

        $vendorRoles = \XLite\Core\Database::getRepo('XLite\Model\Role')
            ->findByPermissionCodePrefix(\XLite\Model\Role\Permission::VENDOR_PERM_CODE_PREFIX);
        $cnd->{\XLite\Model\Repo\Profile::SEARCH_ROLES} = $vendorRoles;

        if (!$countOnly) {
            $cnd->{\XLite\Model\Repo\Profile::ADD_TOTALS} = true;
        }
        $cnd->{\XLite\Model\Repo\Profile::P_ORDER_BY} = $this->getOrderBy();

        if (isset($cnd->{\XLite\Model\Repo\Profile::SEARCH_PROFILE_ID}) && empty($cnd->{\XLite\Model\Repo\Profile::SEARCH_PROFILE_ID})) {
            unset($cnd->{\XLite\Model\Repo\Profile::SEARCH_PROFILE_ID});
        }

        return parent::getData($cnd, $countOnly);;
    }
    
    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'modules/XC/MultiVendor/profile_transactions_stats/style.css';

        return $list;
    }

    /**
     * Get profile
     *
     * @return string
     */
    protected function getSearchProfile()
    {
        $session = \XLite\Core\Session::getInstance()->{$this->getSessionCellName()};

        return $session->{static::PARAM_PROFILE} ?: '';
    }

    /**
     * Get default sort order
     *
     * @return string
     */
    protected function getSortOrderModeDefault()
    {
        return static::SORT_ORDER_DESC;
    }

    /**
     * Return 'Order by' array.
     * array(<Field to order>, <Sort direction>)
     *
     * @return array
     */
    protected function getOrderBy()
    {
        return array($this->getSortBy(), $this->getSortOrder());
    }

    /**
     * Get default sort mode
     *
     * @return string
     */
    protected function getSortByModeDefault()
    {
        return 'p.login';
    }

    /**
     * Define repository name
     *
     * @return string
     */
    protected function defineRepositoryName()
    {
        return 'XLite\Model\Profile';
    }

    /**
     * Get container class
     *
     * @return string
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass() . ' profile-transaction-stats';
    }

    /**
     * Get order
     *
     * @param \XLite\Model\Profile $profile profile
     *
     * @return \XLite\Model\Profile
     */
    protected function getProfileColumnValue(\XLite\Model\Profile $profile)
    {
        return $profile->getLogin();
    }

    /**
     * Get total of vendor account
     *
     * @param \XLite\Model\Profile $profile profile
     *
     * @return decimal
     */
    protected function getBalanceColumnValue(\XLite\Model\Profile $profile)
    {
        $transactions = $profile->getProfileTransactions();
        $sum = 0;
        foreach ($transactions as $transaction) {
            $sum += $transaction->getValue();
        }
        return -1 * $sum;
    }

    /**
     * Get total of vendor account
     *
     * @param \XLite\Model\Profile $profile profile
     *
     * @return decimal
     */
    protected function getDebitTotalColumnValue(\XLite\Model\Profile $profile)
    {
        $transactions = $profile->getProfileTransactions();
        $sum = 0;
        foreach ($transactions as $transaction) {
            $sum += $transaction->getValue() < 0
                ? abs($transaction->getValue())
                : 0;
        }
        return $sum;
    }

    /**
     * Get total of vendor account
     *
     * @param \XLite\Model\Profile $profile profile
     *
     * @return decimal
     */
    protected function getCreditTotalColumnValue(\XLite\Model\Profile $profile)
    {
        $transactions = $profile->getProfileTransactions();
        $sum = 0;
        foreach ($transactions as $transaction) {
            $sum += $transaction->getValue() > 0
                ? abs($transaction->getValue())
                : 0;
        }
        return $sum;
    }

    /**
     * Preprocess value
     *
     * @param decimal              $sum             ProfileTransaction sum
     * @param array                $column          Column info
     * @param \XLite\Model\Profile $profile         Profile
     *
     * @return string
     */
    protected function preprocessBalance($sum, array $column, \XLite\Model\Profile $profile)
    {
        return $this->preprocessHelperPrice($sum);
    }

    /**
     * Preprocess value
     *
     * @param decimal              $sum             ProfileTransaction sum
     * @param array                $column          Column info
     * @param \XLite\Model\Profile $profile         Profile
     *
     * @return string
     */
    protected function preprocessDebitTotal($sum, array $column, \XLite\Model\Profile $profile)
    {
        return $this->preprocessHelperPrice($sum);
    }

    /**
     * Preprocess value
     *
     * @param decimal              $sum             ProfileTransaction sum
     * @param array                $column          Column info
     * @param \XLite\Model\Profile $profile         Profile
     *
     * @return string
     */
    protected function preprocessCreditTotal($sum, array $column, \XLite\Model\Profile $profile)
    {
        return $this->preprocessHelperPrice($sum);
    }

    /**
     * Preprocess helper for prices
     * 
     * @param float     $value      ProfileTransaction value
     * 
     * @return string
     */
    protected function preprocessHelperPrice($value)
    {
        return null !== $value
            ? static::formatPrice(
                $value, \XLite::getInstance()->getCurrency()
            ) : '';
    }

    /**
     * Check - Commission's profile removed or not
     *
     * @param \XLite\Model\Profile $profile profile
     *
     * @return boolean
     */
    protected function isProfileRemoved(\XLite\Model\Profile $profile)
    {
        return !$profile;
    }

    /**
     * Get profile id of vendor owner of this order
     * 
     * @param \XLite\Model\Profile $profile profile
     * 
     * @return integer
     */
    protected function getOwnerVendorProfileId(\XLite\Model\Profile $profile)
    {
        return $profile
            ? $profile->getProfileId()
            : null;
    }
}
