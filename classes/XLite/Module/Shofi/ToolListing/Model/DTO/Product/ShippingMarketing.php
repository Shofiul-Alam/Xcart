<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\Shofi\ToolListing\Model\DTO\Product;

use XLite\Model\DTO\Base\CommonCell;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use XLite\Core\Translation;

class ShippingMarketing extends \XLite\Model\DTO\Base\ADTO
{

    /**
     * @param Info                      $dto
     * @param ExecutionContextInterface $context
     */
    public static function validate($dto, ExecutionContextInterface $context)
    {
        xdebug_break();
        if (!empty($dto->default->sku) && !static::isSKUValid($dto)) {
            static::addViolation($context, 'default.sku', Translation::lbl('SKU must be unique'));
        }

        if ($dto->marketing->meta_description_type === 'C' && '' === trim($dto->marketing->meta_description)) {
            static::addViolation($context, 'marketing.meta_description', Translation::lbl('This field is required'));
        }

    }

    /**
     * @param Info $dto
     *
     * @return boolean
     */
    protected static function isSKUValid($dto)
    {
        xdebug_break();
        $sku      = $dto->default->sku;

        $entity = \XLite\Core\Database::getRepo('XLite\Model\Product')->findOneBySku($sku);

        if($entity) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param mixed|\XLite\Model\Product $object
     */
    protected function init($object)
    {
        xdebug_break();
        $memberships = [];
        foreach ($object->getMemberships() as $membership) {
            $memberships[] = $membership->getMembershipId();
        }

        $taxClass       = $object->getTaxClass();
        $shippingBox    = new CommonCell([
            'separate_box' => $object->getUseSeparateBox(),
            'dimensions'   => [
                'length' => $object->getBoxLength(),
                'width'  => $object->getBoxWidth(),
                'height' => $object->getBoxHeight(),
            ],
        ]);
        $itemsInBox     = new CommonCell([
            'items_in_box' => $object->getItemsPerBox(),
        ]);

        $default = [
            'sku'                  => $object->getSku(),
            'available_for_sale'   => $object->getEnabled(),
            'arrival_date'         => $object->getArrivalDate() ?: time(),
            'memberships'           => $memberships,
            'tax_class'          => $taxClass ? $taxClass->getId() : null,
            'inventory_tracking' => $object->getInventoryEnabled(),
            'quantity'           => $object->getAmount(),
        ];
        $this->default = new CommonCell($default);

        $shippingBox    = new CommonCell([
            'separate_box' => $object->getUseSeparateBox(),
            'dimensions'   => [
                'length' => $object->getBoxLength(),
                'width'  => $object->getBoxWidth(),
                'height' => $object->getBoxHeight(),
            ],
        ]);
        $itemsInBox     = new CommonCell([
            'items_in_box' => $object->getItemsPerBox(),
        ]);
        $shipping       = [
            'weight'            => $object->getWeight(),
            'requires_shipping' => $object->getShippable(),
            'shipping_box'      => $shippingBox,
            'items_in_box'      => $itemsInBox,
        ];
        $this->shipping = new CommonCell($shipping);

        $marketing       = [
            'meta_description_type' => $object->getMetaDescType(),
            'meta_description'      => $object->getMetaDesc(),
            'meta_keywords'         => $object->getMetaTags(),
            'product_page_title'    => $object->getMetaTitle(),
        ];
        $this->marketing = new CommonCell($marketing);
    }

    /**
     * @param \XLite\Model\Product $object
     * @param array|null           $rawData
     *
     * @return mixed
     */
    public function populateTo($object, $rawData = null)
    {
        xdebug_break();
        $default = $this->default;
        $sku = trim($default->sku);
        $object->setSku((string) $sku);
        $object->setEnabled((boolean) $default->available_for_sale);
        $object->setArrivalDate((int) $default->arrival_date);
        xdebug_break();
        $memberships    = \XLite\Core\Database::getRepo('XLite\Model\Membership')->findByIds($default->memberships);
        $object->replaceMembershipsByMemberships($memberships);
        xdebug_break();
        $object->setInventoryEnabled((boolean) $default->inventory_tracking);
        $object->setAmount((int) $default->quantity);

        $taxClass = \XLite\Core\Database::getRepo('XLite\Model\TaxClass')->find($default->tax_class);
        $object->setTaxClass($taxClass);
        xdebug_break();
        $shipping = $this->shipping;
        $object->setWeight((float) $shipping->weight);
        $object->setShippable((boolean) $shipping->requires_shipping);

        $shippingBox = $shipping->shipping_box;
        $object->setUseSeparateBox((boolean) $shippingBox->separate_box);

        $object->setBoxLength($shippingBox->dimensions['length']);
        $object->setBoxWidth($shippingBox->dimensions['width']);
        $object->setBoxHeight($shippingBox->dimensions['height']);

        $object->setItemsPerBox($shipping->items_in_box->items_in_box);

        xdebug_break();

        $marketing = $this->marketing;
        $object->setMetaDescType($marketing->meta_description_type);
        $object->setMetaDesc((string) $marketing->meta_description);
        $object->setMetaTags((string) $marketing->meta_keywords);
        $object->setMetaTitle((string) $marketing->product_page_title);

    }
}
