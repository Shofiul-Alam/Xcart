<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Checkout\Step;

use XLite\Module\XC\MultiVendor;

/**
 * Shipping step
 */
abstract class Shipping extends \XLite\View\Checkout\Step\Shipping implements \XLite\Base\IDecorator
{
    /**
     * Get CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        if (!MultiVendor\Main::isWarehouseMode()) {
            $list[] = 'modules/XC/MultiVendor/shipping_list/style.less';
        }

        return $list;
    }

    /**
     * Check modifier
     *
     * @return boolean
     */
    protected function isModifierCompleted()
    {
        $cart = $this->getCart();

        if ($cart->isParent() && !MultiVendor\Main::isWarehouseMode()) {
            $result = true;

            /** @var \XLite\Model\Cart $child */
            foreach ($cart->getChildren() as $child) {
                $modifier = $child->getModifier(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, 'SHIPPING');

                if (!$this->checkModifier($modifier)) {
                    $result = false;
                    break;
                }
            }
        } else {
            $result = parent::isModifierCompleted();
        }

        return $result;
    }

    /**
     * Check modifier
     *
     * @param \XLite\Model\Order\Modifier $modifier Modifier
     *
     * @return boolean
     */
    protected function checkModifier($modifier)
    {
        return null === $modifier
            || !$modifier->canApply()
            || $modifier->getMethod();
    }
}
