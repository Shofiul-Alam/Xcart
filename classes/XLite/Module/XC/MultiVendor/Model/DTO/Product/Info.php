<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model\DTO\Product;

use XLite\Core;
use XLite\Model\Repo;

/**
 * Product
 */
class Info extends \XLite\Model\DTO\Product\Info implements \XLite\Base\IDecorator
{
    /**
     * @param mixed|\XLite\Model\Product $object
     */
    protected function init($object)
    {
        parent::init($object);

        if (Core\Auth::getInstance()->hasRootAccess()) {
            $this->default->vendor = (string) (int) ($object->getVendorId() ?: Repo\Profile::ADMIN_VENDOR_FAKE_ID);
        }
    }

    /**
     * @param \XLite\Model\Product $object
     * @param array|null           $rawData
     *
     * @return mixed
     */
    public function populateTo($object, $rawData = null)
    {
        parent::populateTo($object, $rawData);

        if (Core\Auth::getInstance()->hasRootAccess()) {
            $vendorId = $this->default->vendor;
            if ($vendorId) {
                $vendor = Core\Database::getRepo('XLite\Model\Profile')->find($vendorId);

                $object->setVendor($vendor && $vendor->isVendor() ? $vendor : null);

                if ($object->isPersistent()) {
                    \XLite\Core\Database::getRepo('XLite\Model\OrderItem')->detachVendorProduct($object);
                }
            }
        } else {
            if (!$object->isPersistent() || !$object->getVendor()) {
                $object->setVendor(Core\Auth::getInstance()->getVendor());
            }
        }
    }
}
