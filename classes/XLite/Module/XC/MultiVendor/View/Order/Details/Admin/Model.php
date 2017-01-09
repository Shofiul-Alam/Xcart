<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Order\Details\Admin;

use Xlite\Core;

/**
 * Model
 */
class Model extends \XLite\View\Order\Details\Admin\Model implements \XLite\Base\IDecorator
{
    /**
     * Define default modifier form field widget
     *
     * @param array $modifier Modifier
     *
     * @return \XLite\View\FormField\Inline\AInline
     */
    protected function defineDefaultModifierWidget(array $modifier)
    {
        $widget = parent::defineDefaultModifierWidget($modifier);
        $order = $this->getOrder();

        if ($order->isSingle() && $order->getSingleVendors()->count() > 1) {
            $value = 0;
            $auth = Core\Auth::getInstance();
            foreach ($order->getExcludeSurcharges() as $surcharge) {
                if ($surcharge->getCode() === $modifier['object']->getCode()
                    && (!$auth->isVendor()
                        || ($surcharge->getVendor() && $surcharge->getVendor()->getProfileId() === $auth->getVendorId())
                    )
                ) {
                    $value += abs($surcharge->getValue());
                }
            }

            $widget->setWidgetParams(array(
                'fieldParams' => array('value' => $value)
            ));
        }

        return $widget;
    }
}
