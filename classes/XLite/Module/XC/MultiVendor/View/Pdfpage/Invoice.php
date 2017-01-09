<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\PdfPage;

/**
 * PDF invoice
 */
class Invoice extends \XLite\View\PdfPage\Invoice implements \XLite\Base\IDecorator
{
    /**
     * CSS for PDF page
     *
     * @return array
     */
    public function getPdfStylesheets()
    {
        return array_merge(
            parent::getPdfStylesheets(),
            array(
                'modules/XC/MultiVendor/order/invoice/vendor_link/style.css',
            )
        );
    }
}
