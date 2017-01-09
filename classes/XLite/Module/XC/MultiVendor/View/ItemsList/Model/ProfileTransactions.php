<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ItemsList\Model;

use XLite\Module\XC\MultiVendor;

/**
 * ProfileTransactions items list
 */
class ProfileTransactions extends \XLite\View\ItemsList\Model\Table
{
    /**
     * Widget param names
     */
    const PARAM_PROFILE                 = 'profile';
    const PARAM_DATE_RANGE              = 'dateRange';
    const PARAM_DESCRIPTION_SUBSTRING   = 'descSubstr';

    /**
     * Sort modes
     *
     * @var   array
     */
    protected $sortByModes = array(
        'p.profile'         => 'Profile',
        'p.date'            => 'Date',
    );

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        $columns = array(
            'author' => array(
                static::COLUMN_NAME                 => static::t('Created by'),
                static::COLUMN_TEMPLATE             => 'modules/XC/MultiVendor/profile_transactions/author.twig',
                static::COLUMN_NO_WRAP              => true,
                static::COLUMN_CREATE_CLASS         => 'XLite\View\FormField\Inline\Select\Profile\Admin',
                static::COLUMN_PARAMS => array(
                    'attributes' => array(
                        'disabled' => true   // It is disabled because widget is used only in multivendor
                    )
                )
            ),
            'date' => array(
                static::COLUMN_CREATE_TEMPLATE => 'modules/XC/MultiVendor/profile_transactions/date.twig',
                static::COLUMN_TEMPLATE => 'modules/XC/MultiVendor/profile_transactions/cell.date.twig',
                static::COLUMN_NAME     => static::t('Date'),
                static::COLUMN_NO_WRAP  => true,
                static::COLUMN_SORT => 'p.date',
            ),
            'order' => array(
                static::COLUMN_NAME => static::t('Order'),
                static::COLUMN_LINK => 'order',
            ),
            'description' => array(
                static::COLUMN_CLASS     => 'XLite\View\FormField\Inline\Input\Text',
                static::COLUMN_NAME => static::t('Description'),
                static::COLUMN_MAIN => true,
                static::COLUMN_TEMPLATE  => 'items_list/model/table/field.twig',
            ),
            'debit' => array(
                static::COLUMN_NAME      => static::t('Income'),
                static::COLUMN_CLASS     => 'XLite\Module\XC\MultiVendor\View\FormField\Inline\Input\TransactionValue',
                static::COLUMN_TEMPLATE  => 'items_list/model/table/field.twig',
            ),
            'credit' => array(
                static::COLUMN_NAME => static::t('Expense'),
                static::COLUMN_MAIN => true,
                static::COLUMN_CLASS     => 'XLite\Module\XC\MultiVendor\View\FormField\Inline\Input\TransactionValue',
                static::COLUMN_TEMPLATE  => 'items_list/model/table/field.twig',
            )
        );

        if (! \XLite\Core\Auth::getInstance()->isVendor()) {
            $columns = array_reverse($columns);

            $columns['profile'] = array(
                static::COLUMN_NAME     => static::t('Vendor'),
                static::COLUMN_TEMPLATE => 'modules/XC/MultiVendor/profile.twig',
                static::COLUMN_NO_WRAP  => true,
                static::COLUMN_SORT => 'p.profile',
                static::COLUMN_CREATE_CLASS     => 'XLite\Module\XC\MultiVendor\View\FormField\Inline\Select\Profile\Vendor',
            );

            $columns = array_reverse($columns);
        }

        return $columns;
    }

    /**
     * @param $transaction \XLite\Module\XC\MultiVendor\Model\ProfileTransaction
     *
     * @return int
     */
    protected function getTransactionTimestamp($transaction)
    {
        return $transaction->getDate()->getTimestamp();
    }

    /**
     * Create entity
     *
     * @return \XLite\Model\AEntity
     */
    protected function createEntity()
    {
        $entity = parent::createEntity();
        $entity->setAuthor(\XLite\Core\Auth::getInstance()->getProfile());

        return $entity;
    }

    /**
     * Return search parameters
     *
     * @return array
     */
    public static function getSearchParams()
    {
        $params = array(
            MultiVendor\Model\Repo\ProfileTransaction::P_DATE_RANGE  => static::PARAM_DATE_RANGE,
            MultiVendor\Model\Repo\ProfileTransaction::P_DESC_SUBSTR => static::PARAM_DESCRIPTION_SUBSTRING,
        );

        if (!\XLite\Core\Auth::getInstance()->isVendor()) {
            $params[MultiVendor\Model\Repo\ProfileTransaction::P_PROFILE] = static::PARAM_PROFILE;
        }

        return $params;
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
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_PROFILE               => new \XLite\Model\WidgetParam\TypeString('Vendor', ''),
            static::PARAM_DATE_RANGE            => new \XLite\Model\WidgetParam\TypeString('Date range', ''),
            static::PARAM_DESCRIPTION_SUBSTRING => new \XLite\Model\WidgetParam\TypeString('Description', ''),
        );
    }

    /**
     * Return params list to use for search
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getSearchCondition()
    {
        $result = parent::getSearchCondition();

        foreach (static::getSearchParams() as $modelParam => $requestParam) {
            $value = is_string($this->getParam($requestParam))
                ? trim($this->getParam($requestParam))
                : $this->getParam($requestParam);

            if (static::PARAM_DATE_RANGE === $requestParam && is_array($value)) {
                foreach ($value as $i => $date) {
                    if (is_string($date) && false !== strtotime($date)) {
                        $value[$i] = strtotime($date);
                    }
                }

            } elseif (static::PARAM_DATE_RANGE === $requestParam && $value) {
                $value = \XLite\View\FormField\Input\Text\DateRange::convertToArray($value);
            }

            $result->$modelParam = $value;
        }

        if (\XLite\Core\Auth::getInstance()->isVendor()) {
            $result->{MultiVendor\Model\Repo\ProfileTransaction::P_PROFILE} = \XLite\Core\Auth::getInstance()->getVendor();
        }

        $result->{MultiVendor\Model\Repo\ProfileTransaction::P_ORDER_BY} = $this->getOrderBy();

        return $result;
    }

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'modules/XC/MultiVendor/profile_transactions/style.css';

        return $list;
    }

    /**
     * Register files from common repository
     *
     * @return array
     */
    protected function getCommonFiles()
    {
        $list = parent::getCommonFiles();

        $list[static::RESOURCE_JS][] = 'js/chosen.jquery.js';

        $list[static::RESOURCE_CSS][] = 'css/chosen/chosen.css';

        return $list;
    }

    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'modules/XC/MultiVendor/profile_transactions/handlers.js';
        $list[] = 'modules/XC/MultiVendor/profile_transactions/profileSelect.js';

        return $list;
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
        return 'p.date';
    }

    /**
     * Define repository name
     *
     * @return string
     */
    protected function defineRepositoryName()
    {
        return 'XLite\Module\XC\MultiVendor\Model\ProfileTransaction';
    }

    /**
     * Get container class
     *
     * @return string
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass() . ' profile-transaction';
    }

    /**
     * Build entity page URL
     *
     * @param \XLite\Model\AEntity $entity Entity
     * @param array                $column Column data
     *
     * @return string
     */
    protected function buildEntityURL(\XLite\Model\AEntity $entity, array $column)
    {
        $order = $entity->getDisplayOrder();
        return 'order' === $column[static::COLUMN_CODE] && $order
            ? \XLite\Core\Converter::buildURL(
                $column[static::COLUMN_LINK],
                '',
                array('order_number' => $order->getOrderNumber())
            )
            : parent::buildEntityURL($entity, $column);
    }

    /**
     * Get order
     *
     * @param \XLite\Module\XC\MultiVendor\Model\ProfileTransaction $transaction Transaction
     *
     * @return string
     */
    protected function getOrderColumnValue(MultiVendor\Model\ProfileTransaction $transaction)
    {
        $order = $transaction->getDisplayOrder();

        return $order
            ? $order->getPrintableOrderNumber()
            : '';
    }

    /**
     * Get order
     *
     * @param \XLite\Module\XC\MultiVendor\Model\ProfileTransaction $transaction ProfileTransaction
     *
     * @return \XLite\Model\Profile
     */
    protected function getProfileColumnValue(MultiVendor\Model\ProfileTransaction $transaction)
    {
        return $transaction->getProfile();
    }

    /**
     * Get commission
     *
     * @param \XLite\Module\XC\MultiVendor\Model\ProfileTransaction $transaction ProfileTransaction
     *
     * @return \XLite\Model\Profile
     */
    protected function getAuthorColumnValue(MultiVendor\Model\ProfileTransaction $transaction)
    {
        return $transaction->getAuthor();
    }

    /**
     * Is transaction provided by paypal
     *
     * @param \XLite\Module\XC\MultiVendor\Model\ProfileTransaction $transaction ProfileTransaction
     *
     * @return boolean
     */
    protected function isPaypalProvider(MultiVendor\Model\ProfileTransaction $transaction)
    {
        return $transaction->getProvider() === MultiVendor\Model\ProfileTransaction::PROVIDER_PAYPAL;
    }

    /**
     * Get provider image url
     *
     * @param \XLite\Module\XC\MultiVendor\Model\ProfileTransaction $transaction ProfileTransaction
     *
     * @return string
     */
    protected function getProviderImageUrl(MultiVendor\Model\ProfileTransaction $transaction)
    {
        return $transaction->getProviderImageUrl();
    }

    /**
     * Prepare field params for 
     *
     * @param array                $column
     * @param \XLite\Model\AEntity $entity
     *
     * @return boolean
     */
    protected function preprocessFieldParams(array $column, \XLite\Model\AEntity $entity)
    {
        $list = parent::preprocessFieldParams($column, $entity);

        if ($column['code'] === 'debit') {
            $list['value'] = $entity->getValue() < 0
                ? abs($entity->getValue())
                : null;;
        } elseif ($column['code'] === 'credit') {
            $list['value'] = $entity->getValue() > 0
                ? abs($entity->getValue())
                : null;;
        }

        return $list;
    }

    /**
     * Preprocess value
     *
     * @param string                                                    $value          Description
     * @param array                                                     $column         Column info
     * @param \XLite\Module\XC\MultiVendor\Model\ProfileTransaction     $transaction    ProfileTransaction object
     *
     * @return string
     */
    protected function preprocessDescription($value, array $column, MultiVendor\Model\ProfileTransaction $transaction)
    {
        return static::t($value);
    }
    /**
     * Get commission
     *
     * @param \XLite\Module\XC\MultiVendor\Model\ProfileTransaction $transaction ProfileTransaction
     *
     * @return \XLite\Model\Profile
     */
    protected function getDebitColumnValue(MultiVendor\Model\ProfileTransaction $transaction)
    {
        return $transaction->getValue() < 0
            ? abs($transaction->getValue())
            : null;
    }

    /**
     * Get commission
     *
     * @param \XLite\Module\XC\MultiVendor\Model\ProfileTransaction $transaction ProfileTransaction
     *
     * @return \XLite\Model\Profile
     */
    protected function getCreditColumnValue(MultiVendor\Model\ProfileTransaction $transaction)
    {
        return $transaction->getValue() > 0
            ? abs($transaction->getValue())
            : null;
    }

    /**
     * Preprocess value
     *
     * @param float                                                     $value          ProfileTransaction value
     * @param array                                                     $column         Column info
     * @param \XLite\Module\XC\MultiVendor\Model\ProfileTransaction     $transaction    ProfileTransaction object
     *
     * @return string
     */
    protected function preprocessDebit($value, array $column, MultiVendor\Model\ProfileTransaction $transaction)
    {
        return $this->preprocessHelperPrice($value);
    }

    /**
     * Preprocess value
     *
     * @param float                                                     $value          ProfileTransaction value
     * @param array                                                     $column         Column info
     * @param \XLite\Module\XC\MultiVendor\Model\ProfileTransaction     $transaction    ProfileTransaction object
     *
     * @return string
     */
    protected function preprocessCredit($value, array $column, MultiVendor\Model\ProfileTransaction $transaction)
    {
        return $this->preprocessHelperPrice($value);
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
        return $value
            ? static::formatPrice($value, \XLite::getInstance()->getCurrency())
            : ' &mdash; ';
    }
    /**
     * Return current date
     *
     * @return string
     */
    protected function getCurrentDate()
    {
        return time();
    }

    /**
     * Preprocess profile
     *
     * @param \XLite\Model\Profile                                      $value          Vendor entity
     * @param array                                                     $column         Column info
     * @param \XLite\Module\XC\MultiVendor\Model\ProfileTransaction     $transaction    ProfileTransaction object
     *
     * @return string
     */
    protected function preprocessProfile($value, array $column, MultiVendor\Model\ProfileTransaction $transaction)
    {
        return $value
            ? $value->getLogin()
            : $transaction->getProfile()->getLogin();
    }

    /**
     * Preprocess profile
     *
     * @param \XLite\Model\Profile                                      $value          Vendor entity
     * @param array                                                     $column         Column info
     * @param \XLite\Module\XC\MultiVendor\Model\ProfileTransaction     $transaction    ProfileTransaction object
     *
     * @return string
     */
    protected function preprocessAuthor($value, array $column, MultiVendor\Model\ProfileTransaction $transaction)
    {
        return $value
            ? $value->getLogin()
            : null;
    }

    /**
     * Get panel class
     *
     * @return \XLite\View\Base\FormStickyPanel
     */
    protected function getPanelClass()
    {
        return \XLite\Core\Auth::getInstance()->isVendor()
            ? null
            : 'XLite\Module\XC\MultiVendor\View\StickyPanel\ItemsList\ProfileTransaction';
    }

    /**
     * Check - Commission's author profile removed or not
     *
     * @param \XLite\Module\XC\MultiVendor\Model\ProfileTransaction $transaction Transaction
     *
     * @return boolean
     */
    protected function isAuthorRemoved(MultiVendor\Model\ProfileTransaction $transaction)
    {
        return !$transaction->getAuthor();
    }

    /**
     * Get profile id of author of this transaction
     *
     * @param \XLite\Module\XC\MultiVendor\Model\ProfileTransaction $transaction Transaction
     *
     * @return integer
     */
    protected function getAuthorProfileId(MultiVendor\Model\ProfileTransaction $transaction)
    {
        return $transaction->getAuthor()
            ? $transaction->getAuthor()->getProfileId()
            : null;
    }

    /**
     * Check - Commission's profile removed or not
     *
     * @param \XLite\Module\XC\MultiVendor\Model\ProfileTransaction $transaction Transaction
     *
     * @return boolean
     */
    protected function isProfileRemoved(MultiVendor\Model\ProfileTransaction $transaction)
    {
        return !$transaction->getProfile();
    }

    /**
     * Get profile id of vendor owner of this order
     *
     * @param \XLite\Module\XC\MultiVendor\Model\ProfileTransaction $transaction Transaction
     *
     * @return integer
     */
    protected function getOwnerVendorProfileId(MultiVendor\Model\ProfileTransaction $transaction)
    {
        return $transaction->getProfile()
            ? $transaction->getProfile()->getProfileId()
            : null;
    }

    /**
     * Get create button label
     *
     * @return string
     */
    protected function getCreateButtonLabel()
    {
        return 'Create transaction';
    }

    /**
     * Get current admin login
     *
     * @return string
     */
    protected function getAdminLogin()
    {
        return \XLite\Core\Auth::getInstance()->getProfile()->getLogin();
    }

    /**
     * Get active vendors count
     *
     * @return integer
     */
    protected function getVendorsCount()
    {
        return \XLite\Core\Database::getRepo('XLite\Model\Profile')->findAllVendors(true);
    }

    /**
     * Inline creation mechanism position
     *
     * @return integer
     */
    protected function isInlineCreation()
    {
        return !\XLite\Core\Auth::getInstance()->isVendor() && 0 < $this->getVendorsCount()
            ? static::CREATE_INLINE_TOP
            : parent::isInlineCreation();
    }

    /**
     * Save new entity
     *
     * @param array                $fields Fields
     * @param \XLite\Model\AEntity $entity Entity object
     * @param array                $line   New entity data from request
     *
     * @return void
     */
    protected function saveNewEntity(array $fields, $entity, $line)
    {
        if (isset($line['debit'])) {
            $entity->setValue(-$line['debit']);

        } elseif (isset($line['credit'])) {
            $entity->setValue($line['credit']);
        }

        parent::saveNewEntity($fields, $entity, $line);
    }

    /**
     * Post-validate new entity
     *
     * @param \XLite\Model\AEntity $entity Entity
     *
     * @return boolean
     */
    protected function prevalidateNewEntity(\XLite\Model\AEntity $entity)
    {
        $result = true;

        if (!$entity->getValue()) {
            \XLite\Core\TopMessage::getInstance()->addError('Value of transaction should not be empty');
            $result = false;
        }

        return $result;
    }

    /**
     * Check if the column template is used for widget displaying
     *
     * @param array                $column Column
     * @param \XLite\Model\AEntity $entity Entity
     *
     * @return boolean
     */
    protected function isTemplateColumnVisible(array $column, \XLite\Model\AEntity $entity)
    {
        $result = parent::isTemplateColumnVisible($column, $entity);

        switch ($column[static::COLUMN_CODE]) {
            case 'credit':
            case 'debit':
            case 'description':
                $result = !$entity->getAuthor() || \XLite\Core\Auth::getInstance()->isVendor();
                break;

            default:
                break;
        }

        return $result;
    }
    /**
     * Check if the simple class is used for widget displaying
     *
     * @param array                $column Column
     * @param \XLite\Model\AEntity $entity Entity
     *
     * @return boolean
     */
    protected function isClassColumnVisible(array $column, \XLite\Model\AEntity $entity)
    {
        $result = parent::isClassColumnVisible($column, $entity);

        switch ($column[static::COLUMN_CODE]) {
            case 'credit':
            case 'debit':
            case 'description':
                $result = !\XLite\Core\Auth::getInstance()->isVendor() && $entity->getAuthor();
                break;

            default:
                break;
        }

        return $result;
    }
}
