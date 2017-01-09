<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Model;

use XLite\Core;

/**
 * Attribute model widget extension
 */
class Attribute extends \XLite\View\Model\Attribute implements \XLite\Base\IDecorator
{
    /**
     * Return true if user can edit attribute data
     *
     * @return boolean
     */
    protected function isAttributeReadonly()
    {
        $productClass = $this->getProductClass();
        
        return Core\Auth::getInstance()->isVendor()
            && (
                !$productClass
                || !Core\Auth::getInstance()->checkVendorAccess($productClass->getVendor())
            );
    }

    /**
     * Return fields list by the corresponding schema
     *
     * @return array
     */
    protected function preprocessFormFieldsForSectionDefault()
    {
        parent::preprocessFormFieldsForSectionDefault();

        if ($this->getModelObject()->getId() && $this->isAttributeReadonly()) {
            $this->extendSchemaDefault();
        }
    }

    /**
     * Extend schemaDefault with additional parameters
     *
     * @return void
     */
    protected function extendSchemaDefault()
    {
        foreach ($this->schemaDefault as $name => $data) {
            $this->schemaDefault[$name][static::SCHEMA_REQUIRED] = false;

            if (empty($this->schemaDefault[$name][static::SCHEMA_ATTRIBUTES])) {
                $this->schemaDefault[$name][static::SCHEMA_ATTRIBUTES] = array();
            }

            $this->schemaDefault[$name][static::SCHEMA_ATTRIBUTES] = array_merge(
                $this->schemaDefault[$name][static::SCHEMA_ATTRIBUTES],
                array(
                    'disabled' => 'disabled',
                    'readonly' => 'readonly'
                )
            );
        }
    }

    /**
     * Perform certain action for the model object
     *
     * @return boolean
     */
    protected function performActionUpdate()
    {
        $result = false;

        if (!$this->getModelObject()->getId() || !$this->isAttributeReadonly()) {
            $result = parent::performActionUpdate();
        }

        return $result;
    }

    /**
     * Return list of the "Button" widgets
     *
     * @return array
     */
    protected function getFormButtons()
    {
        if (Core\Auth::getInstance()->isVendor()
            && 'R' === Core\Config::getInstance()->XC->MultiVendor->attributes_access_mode
            && $this->getModelObject()->getId()
            && !Core\Auth::getInstance()->checkVendorAccess($this->getModelObject()->getVendor())
        ) {
            $result = array();

        } else {
            $result = parent::getFormButtons();
        }

        return $result;
    }
}
