<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Logic;

/**
 * HtmlCleaner cleans an arbitrary html from a potential XSS content
 * @deprecated
 */
class HtmlCleaner extends \XLite\Base
{
    /**
     * Processes html returning purified string
     *
     * @param string $html Html to process
     *
     * @return string
     */
    public static function process($html)
    {
        libxml_use_internal_errors(true);

        if (!empty($html)) {
            $dom = new \DOMDocument();

            if ($dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'))) {
                while (($r = $dom->getElementsByTagName('script')) && $r->length) {
                    $r->item(0)->parentNode->removeChild($r->item(0));
                }

                $html = $dom->saveHTML();
            }
        }

        libxml_use_internal_errors(false);

        return $html;
    }
}