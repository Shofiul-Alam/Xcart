<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Core\Validator;

use XLite\Core;

/**
 * Variant SKU
 *
 * @Decorator\Depend("XC\ProductVariants")
 */
class VariantSKU extends \XLite\Module\XC\ProductVariants\Core\Validator\VariantSKU implements \XLite\Base\IDecorator
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
            $data = $this->sanitize($data);

            $variantId = $this->id;
            $variantsRepo = Core\Database::getRepo('XLite\Module\XC\ProductVariants\Model\ProductVariant');

            $variant = $variantsRepo->find($variantId);
            $vendor = $variant && $variant->getProduct()
                ? $variant->getProduct()->getVendor()
                : Core\Auth::getInstance()->getVendor();

            $productVariants = $variantsRepo->findBySku($data);

            $productVariants = array_filter($productVariants, function ($pv) use ($variantId, $vendor) {
                $otherObject = empty($variantId) || $pv->getId() != $variantId;

                return $otherObject && $pv->getProduct()->getVendor() == $vendor;
            });

            if ($productVariants
                || Core\Database::getRepo('XLite\Model\Product')->findOneBy(array('sku' => $data, 'vendor' => $vendor))
            ) {
                $this->throwSKUError();
            }
        }
    }
}
