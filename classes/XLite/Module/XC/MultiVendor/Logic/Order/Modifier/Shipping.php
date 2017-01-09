<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Logic\Order\Modifier;

use XLite\Model;
use XLite\Module\XC\MultiVendor;

/**
 * Shipping modifier
 */
class Shipping extends \XLite\Logic\Order\Modifier\Shipping implements \XLite\Base\IDecorator
{
    /**
     * Calculate
     * Calculate shipping only for end orders (parent for warehouse
     * mode and children for non warehouse mode)
     *
     * @return \XLite\Model\Order\Surcharge
     */
    public function calculate()
    {
        $order = $this->getOrder();
        $warehouseMode = MultiVendor\Main::isWarehouseMode();

        return !($order instanceof Model\Cart)
            || (($order->isChild() && !$warehouseMode) || ($order->isParent() && $warehouseMode))
                ? parent::calculate()
                : null;
    }

    /**
     * Return intersect of rates (combine rates from children carts for non warehouse mode)
     * @deprecated
     * @unused
     *
     * @param array $rates Rates
     *
     * @return array
     */
    protected function intersectRates($rates)
    {
        $result = array();

        if ($rates) {
            foreach (array_shift($rates) as $rate) {
                $combinedRate = $rate;

                $combinedRate->setBaseRate($this->roundShippingCost($combinedRate->getBaseRate()));
                $combinedRate->setMarkupRate($this->roundShippingCost($combinedRate->getMarkupRate()));

                foreach ($rates as $ratesList) {
                    $subRate = static::findRateByMethodId($ratesList, $rate->getMethod()->getMethodId());

                    if ($subRate) {
                        $combinedRate->setBaseRate(
                            $combinedRate->getBaseRate() + $this->roundShippingCost($subRate->getBaseRate())
                        );
                        $combinedRate->setMarkupRate(
                            $combinedRate->getMarkupRate() + $this->roundShippingCost($subRate->getMarkupRate())
                        );
                    } else {
                        $combinedRate = null;

                        break;
                    }
                }

                if ($combinedRate) {
                    $result[] = $combinedRate;
                }
            }
        }

        return $result;
    }

    /**
     * Returns rate by method id
     *
     * @param array   $rates    Rates
     * @param integer $methodId Method Id
     *
     * @return \XLite\Model\Shipping\Rate
     */
    protected static function findRateByMethodId($rates, $methodId)
    {
        return array_reduce($rates, function ($carry, $item) use ($methodId) {
            return $carry ?: ($item->getMethod()->getMethodId() === $methodId ? $item : null);
        }, null);
    }

    /**
     * Retrieve available shipping rates
     *
     * @return array
     */
    protected function retrieveRates()
    {
        $order = $this->getOrder();
        $result = array();

        if ($order instanceof Model\Cart
            && $order->isParent()
            && !MultiVendor\Main::isWarehouseMode()
        ) {
            $rates = array();
            foreach ($order->getChildren() as $child) {
                $modifier = $child->getModifier(Model\Base\Surcharge::TYPE_SHIPPING, 'SHIPPING');

                if ($modifier) {
                    $rates[] = $modifier->getRates();
                }
            }

            $result = $rates
                ? call_user_func_array('array_merge', $rates)
                : $rates;

        } elseif (!($order instanceof Model\Cart)
            || $order->isParent()
            || !MultiVendor\Main::isWarehouseMode()
        ) {
            $result = Model\Shipping::getInstance()->getRates($this);
        }

        return $result;
    }

    /**
     * Round shipping cost by order currency
     *
     * @param mixed $value
     *
     * @return float
     */
    protected function roundShippingCost($value)
    {
        return $this->getOrder()->getCurrency()->roundValue($value);
    }
}
