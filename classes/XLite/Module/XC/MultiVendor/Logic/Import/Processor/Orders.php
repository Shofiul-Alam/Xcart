<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Logic\Import\Processor;

use XLite\Core\Session;
use \XLite\Model\Order;
use \XLite\Core\Database;

/**
 * Class Orders
 *
 * @Decorator\Depend("XC\OrdersImport")
 */
class Orders extends \XLite\Module\XC\OrdersImport\Logic\Import\Processor\Orders implements \XLite\Base\IDecorator
{
    /**
     * Initialize
     *
     * @return void
     */
    protected function initialize()
    {
        parent::initialize();

        // collect here orders as ['child_orderNumber' => parent_id]
        Session::getInstance()->importedOrderParents = array();

        // collect here orders as ['parent_orderNumber' => child_id]
        Session::getInstance()->importedOrderChildren = array();
    }

    /**
     * Define columns
     *
     * @return array
     */
    protected function defineColumns()
    {
        $columns = parent::defineColumns();

        $afterNumberColumns = [
            'vendor' => [],
            'children' => [
                static::COLUMN_IS_KEY => true
            ],
            'parent' => [
                static::COLUMN_IS_KEY => true
            ],
        ];
        $columns = array_splice($columns, 0, 1) + $afterNumberColumns + $columns;

        //orderNumber, children, parent - for verification
        $columns['orderIdentity'] = [
            static::COLUMN_IS_MULTICOLUMN => true,
            static::COLUMN_IS_MULTIROW => true,
            static::COLUMN_HEADER_DETECTOR => true,
            static::COLUMN_IS_IMPORT_EMPTY => true,
        ];

        return $columns;
    }

    /**
     * Detect shippingStatus header(s)
     *
     * @param array $column Column info
     * @param array $row    Header row
     *
     * @return array
     */
    protected function detectOrderIdentityHeader(array $column, array $row)
    {
        return $this->detectHeaderByPattern('(orderNumber|children|parent)', $row);
    }

    /**
     * Get messages
     *
     * @return array
     */
    public static function getMessages()
    {
        return parent::getMessages()
        + [
            'ORDER-VENDOR-FMT' => 'Wrong vendor format',
            'ORDER-CHILD-NUMBER-FMT' => 'Wrong child order number format',
            'ORDER-PARENT-NUMBER-FMT' => 'Wrong parent order number format',
        ];
    }

    /**
     * Verify 'orderNumber' value
     *
     * @param mixed $value  Value
     * @param array $column Column info
     */
    protected function verifyOrderNumber($value, array $column)
    {
    }

    /**
     * Verify 'orderIdentity' value
     *
     * @param mixed $value  Value
     * @param array $column Column info
     */
    protected function verifyOrderIdentity($value, array $column)
    {
        foreach ($value as &$field) {
            $field = array_shift($field);
        }

        if (!isset($value['orderNumber'])) {
            $this->addError('ORDER-NUMBER-FMT', ['column' => $column, 'value' => $value['orderNumber']]);
        } elseif (!empty($value['orderNumber']) || (empty($value['children']) && empty($value['parent']))) {
            parent::verifyOrderNumber($value['orderNumber'], $column);
        } elseif (!empty($value['parent'])) {
            if ($this->verifyValueAsEmpty($value['parent'])) {
                $this->addError('ORDER-PARENT-NUMBER-FMT', ['column' => $column, 'value' => $value['parent']]);
            }
        } else {
            $childNumbers = array_filter(explode(static::SUBVALUE_DELIMITER, $value['children']));

            if (empty($childNumbers)) {
                $this->addError('ORDER-CHILD-NUMBER-FMT', ['column' => $column, 'value' => $value['children']]);
            }
        }
    }

    /**
     * Verify 'orderNumber' value
     *
     * @param mixed $value  Value
     * @param array $column Column info
     */
    protected function verifyVendor($value, array $column)
    {
        if (!$this->verifyValueAsEmpty($value) && !$this->verifyValueAsEmail($value)) {
            $this->addWarning('ORDER-VENDOR-FMT', ['column' => $column, 'value' => $value['children']]);
        }
    }

    /**
     * Import 'oderNumber' value
     *
     * @param Order  $order  Order
     * @param string $value  Value
     * @param array  $column Column info
     */
    protected function importOrderNumberColumn(Order $order, $value, array $column)
    {
        if (!empty($value)) {
            $order->setOrderNumber($value);

            if (isset(Session::getInstance()->importedOrderParents[$value])) {
                $order->setParent(Database::getRepo('XLite\Model\Order')->find(Session::getInstance()->importedOrderParents[$value]));
            }

            if (isset(Session::getInstance()->importedOrderChildren[$value])) {
                $child = Database::getRepo('XLite\Model\Order')->find(Session::getInstance()->importedOrderChildren[$value]);
                $child->setParent($order);
            }
        }
    }

    /**
     * Import 'children' value
     *
     * @param Order $order  Order
     * @param array $value  Value
     * @param array $column Column info
     */
    protected function importChildrenColumn(Order $order, $value, array $column)
    {
        $childNumbers = array_filter(explode(static::SUBVALUE_DELIMITER, $value));

        foreach ($childNumbers as $childNumber) {
            if ($child = Database::getRepo('XLite\Model\Order')->findOneBy(['orderNumber' => $childNumber])) {
                $child->setParent($order);
            }

            $parents = Session::getInstance()->importedOrderParents;
            $parents[$childNumber] = $order->getOrderId();
            Session::getInstance()->importedOrderParents = $parents;
        }
    }

    /**
     * Import 'parent' value
     *
     * @param Order $order  Order
     * @param string $value  Value
     * @param array $column Column info
     */
    protected function importParentColumn(Order $order, $value, array $column)
    {
        if (!empty($value)) {
            if ($parent = Database::getRepo('XLite\Model\Order')->findOneBy(['orderNumber' => $value])) {
                $order->setParent($parent);
            }

            $children = Session::getInstance()->importedOrderChildren;
            $children[$value] = $order->getOrderId();
            Session::getInstance()->importedOrderChildren = $children;
        }
    }

    /**
     * Import 'vendor' value
     *
     * @param Order $order  Order
     * @param array $value  Value
     * @param array $column Column info
     */
    protected function importVendorColumn(Order $order, $value, array $column)
    {
        if (!empty($value)) {
            if ($vendors = Database::getRepo('XLite\Model\Profile')->findVendorsByTerm($value, 1)) {
                $order->setVendor(array_pop($vendors));
            }
        }
    }

    /**
     * Create model
     *
     * @param array $data Data
     *
     * @return \XLite\Model\AEntity
     */
    protected function createModel(array $data)
    {
        if (!empty($data['children']) || !empty($data['parent'])) {
            return $this->getRepository()->insert(null, true);
        }

        return parent::createModel($data);
    }

    /**
     * Detect model
     *
     * @param array $data Data
     *
     * @return \XLite\Model\AEntity
     */
    protected function detectModel(array $data)
    {
        if (empty($data['orderNumber'])) {
            if (!empty($data['children'])) {
                $childNumbers = array_filter(explode(static::SUBVALUE_DELIMITER, $data['children']));

                foreach ($childNumbers as $childNumber) {
                    $order = Database::getRepo('XLite\Model\Order')->findOneBy(['orderNumber' => $childNumber]);
                    if ($order && $order->getParent()) {
                        return $order->getParent();
                    }
                }
            }

            if (!empty($data['parent']) && !empty($data['vendor'])) {
                $parent = Database::getRepo('XLite\Model\Order')->findOneBy(['orderNumber' => $data['parent']]);
                if ($parent && $parent->getChildren()) {
                    foreach ($parent->getChildren() as $child) {
                        if ($child->getVendor() && $child->getVendor()->getLogin() == trim($data['vendor'])) {
                            return $child;
                        }
                    }
                }
            }
        }

        return parent::detectModel($data);
    }

    /**
     * Import 'transactions' value
     *
     * @param Order $order  Order
     * @param array $value  Value
     * @param array $column Column info
     */
    protected function importTransactionsColumn(Order $order, $value, array $column)
    {
        parent::importTransactionsColumn($order, $value, $column);

        if ($parent = $order->getParent()) {
            foreach ($parent->getPaymentTransactions() as $transaction) {
                if ($method = $transaction->getPaymentMethod()) {
                    $order->setPaymentMethodName($method->getName());
                    break;
                } elseif ($name = $transaction->getMethodName()) {
                    $order->setPaymentMethodName($name);
                    break;
                }
            }
        } else {
            foreach ($order->getChildren() as $child) {
                foreach ($order->getPaymentTransactions() as $transaction) {
                    if ($method = $transaction->getPaymentMethod()) {
                        $child->setPaymentMethodName($method->getName());
                        break;
                    } elseif ($name = $transaction->getMethodName()) {
                        $child->setPaymentMethodName($name);
                        break;
                    }
                }
            }
        }
    }

    /**
     * Import 'shippingMethod' value
     *
     * @param Order  $order  Order
     * @param string $value  Value
     * @param array  $column Column info
     */
    protected function importShippingMethodColumn(Order $order, $value, array $column)
    {
        if (empty($value) && $parent = $order->getParent()) {
            if ($parent->getShippingId()) {
                $order->setShippingId($parent->getShippingId());
            }
            $order->setShippingMethodName($parent->getShippingMethodName());
        } else {
            parent::importShippingMethodColumn($order, $value, $column);

            foreach ($order->getChildren() as $child) {
                if ($order->getShippingId()) {
                    $child->setShippingId($order->getShippingId());
                }
                $child->setShippingMethodName($order->getShippingMethodName());
            }
        }
    }
}