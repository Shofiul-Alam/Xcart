<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Core\Validator\Variant;

use XLite\Core;

/**
 * Product SKU validator
 *
 * @Decorator\Depend({"XC\ProductVariants", "XC\MultiVendor"})
 */
class SKU extends \XLite\Core\Validator\SKU implements \XLite\Base\IDecorator
{
    /**
     * Validate
     *
     * @param mixed $data Data
     *
     * @return void
     */
    public function validate($data)
    {
        if (!Core\Converter::isEmptyString($data)) {
            $product = !empty($this->productId) ?
                Core\Database::getRepo('XLite\Model\Product')->find($this->productId) : null;

            $vendor = $product ? $product->getVendor() : Core\Auth::getInstance()->getVendor();

            $entity = Core\Database::getRepo('XLite\Model\Product')->findOneBy(
                array(
                    'sku'    => $this->sanitize($data),
                    'vendor' => $vendor,
                )
            );

            if ($entity && (empty($this->productId) || $entity->getProductId() != $this->productId)) {
                $this->throwSKUError();

            } else {
                $variantsRepo = Core\Database::getRepo('XLite\Module\XC\ProductVariants\Model\ProductVariant');

                $variants = $variantsRepo->findBySku($this->sanitize($data));

                $variants = array_filter($variants, function ($pv) use ($vendor) {
                    return $pv->getProduct()->getVendor() == $vendor;
                });

                if (!empty($variants)) {
                    $this->throwVariantSKUError();
                }
            }
        }
    }
}
