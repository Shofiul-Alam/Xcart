<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\Shofi\ToolListing\View\Model;

/**
 * Product view model
 */
class ShippingMarketing extends \XLite\View\Model\AModel
{
    /**
     * Schema default
     *
     * @var array
     */
    protected $schemaDefault = array(
        'sku' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text\SKU',
            self::SCHEMA_LABEL    => 'SKU',
            self::SCHEMA_REQUIRED => false,
        ),
        'taxClass' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Select\TaxClass',
            self::SCHEMA_LABEL    => 'Tax class',
            self::SCHEMA_REQUIRED => false,
        ),
        'qty' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text\ProductQuantity',
            self::SCHEMA_LABEL    => 'Quantity in stock',
            self::SCHEMA_REQUIRED => false,
        ),
        'weight' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text\Weight',
            self::SCHEMA_LABEL    => 'Weight X',
            self::SCHEMA_REQUIRED => false,
        ),
        'shippable' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Select\YesNo',
            self::SCHEMA_LABEL    => 'Requires shipping',
            self::SCHEMA_REQUIRED => false,
        ),
        'useSeparateBox' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Select\Product\UseSeparateBox',
            self::SCHEMA_LABEL    => 'Ship in a separate box',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_DEPENDENCY => array(
                self::DEPENDENCY_SHOW => array(
                    'shippable' => array(\XLite\View\FormField\Select\YesNo::YES),
                ),
            ),
        ),
        'enabled' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Checkbox\Enabled',
            self::SCHEMA_LABEL    => 'Available for sale',
            self::SCHEMA_REQUIRED => false,
        ),
        'arrivalDate' => array(
            self::SCHEMA_CLASS    => 'XLite\View\DatePicker',
            self::SCHEMA_LABEL    => 'Arrival date',
            \XLite\View\FormField\AFormField::PARAM_FIELD_ONLY => false,
            self::SCHEMA_REQUIRED => false,
        ),
        'meta_title' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Product page title',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_COMMENT  => 'Leave blank to use product name as Page Title.',
        ),
        'meta_tags' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Meta keywords',
            self::SCHEMA_REQUIRED => false,
        ),
        'meta_desc_type' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Select\MetaDescriptionType',
            self::SCHEMA_LABEL    => 'Meta description',
            self::SCHEMA_REQUIRED => false,
        ),
        'meta_desc' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Textarea\Simple',
            self::SCHEMA_LABEL    => '',
            \XLite\View\FormField\AFormField::PARAM_USE_COLON => false,
            self::SCHEMA_REQUIRED => true,
            self::SCHEMA_DEPENDENCY => array(
                self::DEPENDENCY_SHOW => array (
                    'meta_desc_type' => array('C'),
                )
            ),
        ),
    );

    /**
     * Return current model ID
     *
     * @return integer
     */
    public function getModelId()
    {
        return \XLite\Core\Request::getInstance()->product_id;
    }

    /**
     * getDefaultFieldValue
     *
     * @param string $name Field name
     *
     * @return mixed
     */
    public function getDefaultFieldValue($name)
    {
        $value = parent::getDefaultFieldValue($name);

        // Categories can be provided via request
        if ('categories' === $name) {
            $categoryId = \XLite\Core\Request::getInstance()->category_id;
            $value = $categoryId ? array(
                \XLite\Core\Database::getRepo('XLite\Model\Category')->find($categoryId),
            ) : $value;
        }

        return $value;
    }

    /**
     * This object will be used if another one is not passed
     *
     * @return \XLite\Model\Category
     */
    protected function getDefaultModelObject()
    {
        $model = $this->getModelId()
            ? \XLite\Core\Database::getRepo('XLite\Model\Product')->find($this->getModelId())
            : null;

        return $model ?: new \XLite\Model\Product;
    }

    /**
     * Return name of web form widget class
     *
     * @return string
     */
    protected function getFormClass()
    {
        return 'XLite\Module\Shofi\ToolListing\View\Form\Modify\ShippingMarketing';
    }

    /**
     * Return list of the "Button" widgets
     *
     * @return array
     */
    protected function getFormButtons()
    {
        $result = parent::getFormButtons();
        $result['submit'] = new \XLite\View\Button\Submit(
            array(
                \XLite\View\Button\AButton::PARAM_LABEL    => 'Update',
                \XLite\View\Button\AButton::PARAM_BTN_TYPE => 'regular-main-button',
                \XLite\View\Button\AButton::PARAM_STYLE    => 'action',
            )
        );

        return $result;
    }

    /**
     * Populate model object properties by the passed data.
     * Specific wrapper for setModelProperties method.
     *
     * @param array $data Data to set
     *
     * @return void
     */
    protected function updateModelProperties(array $data)
    {
        xdebug_break();
        $categoryIds = isset($data['categories']) ? array_map('intval', $data['categories']) : array();
        unset($data['categories']);

        $memberships = isset($data['memberships']) ? $data['memberships'] : array();
        unset($data['memberships']);

        // Flag variables
        foreach (array('shippable', 'useSeparateBox') as $value) {
            if (isset($data[$value]) && is_string($data[$value])) {
                $data[$value] = 'Y' === $data[$value];
            }
        }

        if (isset($data['useSeparateBox']) && $data['useSeparateBox']) {
            foreach (array('boxLength', 'boxWidth', 'boxHeight', 'itemsPerBox') as $var) {
                $data[$var] = $this->getPostedData($var);
            }
        }

        if (in_array('arrivalDate', array_keys($data))) {

            // If $data has 'arrivalDate' key...

            if (isset($data['arrivalDate']) && !is_numeric($data['arrivalDate'])) {
                // Try to get timestamp
                $time = \XLite\Core\Converter::time();
                $data['arrivalDate'] = mktime(0, 0, 0, date('m', $time), date('j', $time), date('Y', $time));
            }

            if (is_null($data['arrivalDate'])) {
                // Remove 'arrivalDate' from model parameters if value is null (wrong timestamp)
                unset($data['arrivalDate']);
                \XLite\Core\TopMessage::addWarning('Wrong value specified for arrival date field. The field was not updated.');
            }
        }

        if (isset($data['productClass'])) {
            $data['productClass'] = \XLite\Core\Database::getRepo('XLite\Model\ProductClass')
                ->find($data['productClass']);
        }

        if (isset($data['taxClass'])) {
            $data['taxClass'] = \XLite\Core\Database::getRepo('XLite\Model\TaxClass')->find($data['taxClass']);
        }

        if (isset($data['qty'])) {
            if ($this->getModelObject()) {
                $this->getModelObject()->setAmount($data['qty']);
            }
            unset($data['qty']);
        }

        parent::setModelProperties($data);

        /** @var \XLite\Model\Product $model */
        $model = $this->getModelObject();

        $isNew = !$model->isPersistent();
        $model->update();

        if ($isNew) {
            \XLite\Core\Database::getRepo('XLite\Model\Attribute')->generateAttributeValues($model);
        }

        // Update product categories
        $this->updateProductCategories($model, $categoryIds);

        // Update SKU
        if(
            !trim($model->getSku())
            || null === $model->getSku()
        ) {
            $model->setSku(\XLite\Core\Database::getRepo('XLite\Model\Product')->generateSKU($model));
        }

        // Update memberships
        foreach ($model->getMemberships() as $membership) {
            $membership->getProducts()->removeElement($model);
        }

        $model->getMemberships()->clear();

        if (null !== $memberships && $memberships) {
            // Add new links
            foreach ($memberships as $mid) {
                $membership = \XLite\Core\Database::getRepo('XLite\Model\Membership')->find($mid);
                if ($membership) {
                    $model->addMemberships($membership);
                    $membership->addProduct($model);
                }
            }
        }

        // Set the controller model product
        $this->setProduct($model);
    }
}
