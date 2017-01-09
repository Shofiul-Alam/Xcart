<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\ItemsList\Model\Order\Admin;

use XLite\Core;
use XLite\Model;
use XLite\Model\Repo;

/**
 * Search order
 */
class Search extends \XLite\View\ItemsList\Model\Order\Admin\Search implements \XLite\Base\IDecorator
{
    /**
     * Widget param names
     */
    const PARAM_VENDOR_ID           = 'vendorId';
    const PARAM_VENDOR              = 'vendor';
    const PARAM_COMMISSION_MODE     = 'commissionMode';

    /**
     * Allowed sort criterions
     */
    const SORT_BY_COMMISSION = 'commissionValue';

    /**
     * Define and set widget attributes; initialize widget
     *
     * @param array $params Widget params OPTIONAL
     */
    public function __construct(array $params = array())
    {
        $this->sortByModes += array(
            static::SORT_BY_COMMISSION           => 'Commission',
        );

        parent::__construct($params);
    }

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        $columns = parent::defineColumns();

        $name = static::t('Commission');
        if (Core\Auth::getInstance()->isVendor()) {
            $name = static::t('Earnings');
        }

        $columns += array(
            'commission' => array(
                static::COLUMN_NAME     => $name,
                static::COLUMN_SORT     => static::SORT_BY_COMMISSION,
                static::COLUMN_ORDERBY  => 700,
            )
        );

        // Replace default profile template with the custom one
        $columns['profile'][static::COLUMN_TEMPLATE] = 'modules/XC/MultiVendor/item_lists/order/cell.profile.twig';

        return $columns;
    }

    /**
     * Get commission for current vendor in order
     * 
     * @param \XLite\Model\Order $order Order
     * 
     * @return \XLite\Module\XC\MultiVendor\Model\Commission
     */
    protected function getCommission(Model\Order $entity)
    {
        if (!$entity->isSingle() && Core\Auth::getInstance()->isVendor()) {
            $entity = $entity->isOfCurrentVendor()
                ? $entity
                : $entity->getChildByVendor(Core\Auth::getInstance()->getProfile());
        }

        return $entity
            ? $entity->getCommission()
            : null;
    }

    /**
     * Get commission summary in order
     * 
     * @param \XLite\Model\Order $order Order
     * 
     * @return float
     */
    protected function getCommissionsSummary(Model\Order $entity)
    {
        $sum = 0;

        if (!$entity->isSingle()) {
            $sum = array_reduce(
                $entity->getChildren()->toArray(),
                function ($carry, $child) {
                    $commission = $child->getCommission();
                    return $commission
                        ? $carry + $commission->getValue()
                        : $carry;
                }
            );
        } elseif ($entity->getCommission()) {
            $sum = $entity->getCommission()->getValue();
        }

        return $sum;
    }

    /**
     * Check if commission is auto
     *
     * @param \XLite\Model\Order $order Order
     *
     * @return boolean
     */
    protected function isAutoCommission(Model\Order $entity)
    {
        $commission = $this->getCommission($entity);

        return $commission
            ? $commission->getAuto()
            : null;
    }

    /**
     * Get auto image url
     * 
     * @param \XLite\Model\Order $order Order
     * 
     * TODO Create provider field in commission when there will be more than one
     * @return string
     */
    protected function getAutoImageUrl(Model\Order $entity)
    {
        return \XLite\Core\Layout::getInstance()->getResourceWebPath(
            'modules/CDev/Paypal/method_icon.png'
        );
    }

    /**
     * Return search parameters
     *
     * @return array
     */
    public static function getSearchParams()
    {
        return parent::getSearchParams() + array(
            Repo\Order::P_VENDOR_ID         => static::PARAM_VENDOR_ID,
            Repo\Order::P_VENDOR            => static::PARAM_VENDOR,
            Repo\Order::P_COMMISSION_MODE   => static::PARAM_COMMISSION_MODE
        );
    }

    /**
     * Mark list as removable
     *
     * @return boolean
     */
    protected function isRemoved()
    {
        return parent::isRemoved() && !Core\Auth::getInstance()->isVendor();
    }

    /**
     * Check - order's profile removed or not
     *
     * @param \XLite\Model\Order $order Order
     *
     * @return boolean
     */
    protected function isProfileRemoved(Model\Order $order)
    {
        return parent::isProfileRemoved($order) || Core\Auth::getInstance()->isVendor();
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
            static::PARAM_VENDOR_ID         => new Model\WidgetParam\TypeInt('Vendor ID', 0),
            static::PARAM_VENDOR            => new Model\WidgetParam\TypeString('Vendor', ''),
            static::PARAM_COMMISSION_MODE   => new Model\WidgetParam\TypeString('CommissionMode', ''),
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

        if (isset($result->{static::PARAM_VENDOR_ID})
            && is_numeric($result->{static::PARAM_VENDOR_ID})
        ) {
            unset($result->{static::PARAM_VENDOR});

        } else {
            unset($result->{static::PARAM_VENDOR_ID});
        }

        if (\XLite\Core\Auth::getInstance()->isVendor()
            && !\XLite\Core\Auth::getInstance()->isPermissionAllowed('manage orders')
        ) {
            unset($result->{static::PARAM_VENDOR_ID});
            unset($result->{static::PARAM_VENDOR});
        }

        return $result;
    }

    /**
     * Get items sum quantity
     *
     * @param \XLite\Model\Order $order Order
     *
     * @return integer
     */
    protected function getItemsQuantity(\XLite\Model\Order $order)
    {
        if (Core\Auth::getInstance()->isVendor()) {
            if ($order->isSingle()) {
                $order = $order->isOfCurrentVendor()
                    ? $order
                    : $order->getChildByVendor(Core\Auth::getInstance()->getProfile());
                $result = $order->countQuantity();

            } else {
                $vendor = Core\Auth::getInstance()->getProfile();
                $result = array_reduce($order->getItems()->toArray(), function ($carry, $item) use ($vendor) {
                    return $item->getVendor() && $item->getVendor()->getProfileId() === $vendor->getProfileId()
                        ? $carry + $item->getAmount()
                        : $carry;
                }, 0);
            }

        } else {
            $result = $order->countQuantity();
        }

        return $result;
    }

    /**
     * Get total column
     * 
     * @param string $name Column code
     * 
     * @return array
     */
    protected function getColumnByCode($code)
    {
        $codeField = static::COLUMN_CODE;

        return array_reduce(
            $this->getColumns(),
            function($carry, $column) use ($code, $codeField) {
                if (!$carry && $code === $column[$codeField]) {
                    $carry = $column;
                }
                return $carry;
            }
        );
    }

    /**
     * Get commission
     *
     * @param \XLite\Model\AEntity $entity order
     *
     * @return string
     */
    protected function getCommissionColumnValue(\XLite\Model\AEntity $entity)
    {
        $summary = null;
        $commission = $this->getCommission($entity);

        if ($commission) {
            $summary = $commission->getValue();
        } else {
            $summary = $this->getCommissionsSummary($entity);
        }

        if ($summary && !Core\Auth::getInstance()->isVendor()) {
            $summary = $this->getVendorTotalValue($this->getColumnByCode('total'), $entity) - $summary;
        }

        return $summary
            ? static::formatPrice($summary, $entity->getCurrency())
            : '';
    }

    /**
     * Get vendor total value
     *
     * @param array                $column Column
     * @param \XLite\Model\AEntity $entity Model
     *
     * @return mixed
     */
    protected function getVendorTotalValue(array $column, \XLite\Model\AEntity $entity)
    {
        $result = 0;

        if ($entity->isChild()) {
            $result = $this->getColumnValue($column, $entity);
        } else {
            $items = $entity->getItems();
            $itemsResult = array_reduce($items->toArray(), function ($carry, $item){
                return $item->getVendor() && $item->getVendor()->getProfileId() !== \XLite\Model\Repo\Profile::ADMIN_VENDOR_FAKE_ID
                    ? $carry + $item->getTotal()
                    : $carry;
            }, 0);

            $surcharges = $entity->getSurcharges();
            $surchargesResults = array_reduce($surcharges->toArray(), function ($carry, $item){
                return $item->getVendor() && $item->getVendor()->getProfileId() !== \XLite\Model\Repo\Profile::ADMIN_VENDOR_FAKE_ID
                    ? $carry + $item->getValue()
                    : $carry;
            }, 0);

            $result = $itemsResult + $surchargesResults;
        }

        return $result;
    }

    /**
     * Get column value
     *
     * @param array                $column Column
     * @param \XLite\Model\AEntity $entity Model
     *
     * @return mixed
     */
    protected function getColumnValue(array $column, \XLite\Model\AEntity $entity)
    {
        $auth = Core\Auth::getInstance();
        switch ($column[static::COLUMN_CODE]) {
            case 'total':
                if ($auth->isVendor()) {
                    if (!$entity->isSingle()) {
                        $entity = $entity->isOfCurrentVendor()
                            ? $entity
                            : $entity->getChildByVendor($auth->getProfile());
                        $result = $entity ? parent::getColumnValue($column, $entity) : null;

                    } else {
                        $items = $entity->getItems();
                        $itemsResult = array_reduce($items->toArray(), function ($carry, $item) use ($auth) {
                            return $item->getVendor() && $item->getVendor()->getProfileId() === $auth->getVendorId()
                                ? $carry + $item->getTotal()
                                : $carry;
                        }, 0);

                        $surcharges = $entity->getSurcharges();
                        $surchargesResults = array_reduce($surcharges->toArray(), function ($carry, $item) use ($auth) {
                            return $item->getVendor() && $item->getVendor()->getProfileId() === $auth->getVendorId()
                                ? $carry + $item->getValue()
                                : $carry;
                        }, 0);

                        $result = $itemsResult + $surchargesResults;
                    }
                } else {
                    $result = parent::getColumnValue($column, $entity);
                }

                break;
            default:
                $result = parent::getColumnValue($column, $entity);
        }

        return $result;
    }

    /**
     * Return true if custom template should be used to display info about customer who placed order
     *
     * @return boolean
     */
    protected function isDisplayCustomProfileInfo()
    {
        return Core\Auth::getInstance()->isVendor() && Core\Config::getInstance()->XC->MultiVendor->mask_contacts;
    }
}
