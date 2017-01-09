<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\Shofi\ToolListing\View\FormModel\Product;

class ShippingMarketing extends \XLite\View\FormModel\AFormModel
{
    /**
     * Do not render form_start and form_end in null returned
     *
     * @return string|null
     */
    protected function getTarget()
    {

        return 'tool';
    }

    /**
     * @return string
     */
    protected function getAction()
    {
        xdebug_break();
        return 'updateShippingMarketing';
    }

    /**
     * @return array
     */
    protected function getActionParams()
    {
        xdebug_break();
        $params = ['page' => 'shippingMarketing'];

        $identity = $this->getProduct()->getProductId();

        return $identity ? array_replace($params, ['product_id' => $identity]) : $params;
    }

    protected function defineSections()
    {

        return array_replace(parent::defineSections(), [
            'shipping'             => [
                'label'    => static::t('Shipping'),
                'position' => 200,
            ],
            'marketing'            => [
                'label'    => static::t('Marketing'),
                'position' => 300,
            ],
        ]);
    }

    /**
     * @return array
     */
    protected function defineFields()
    {
        /**
         * Edit Started
         */
        xdebug_break();

        $skuMaxLength  = \XLite\Core\Database::getRepo('XLite\Model\Product')->getFieldInfo('sku', 'length');

        $memberships = [];
        foreach (\XLite\Core\Database::getRepo('XLite\Model\Membership')->findActiveMemberships() as $membership) {
            $memberships[$membership->getMembershipId()] = $membership->getName();
        }

        $taxClasses = [];
        foreach (\XLite\Core\Database::getRepo('XLite\Model\TaxClass')->findAll() as $taxClass) {
            $taxClasses[$taxClass->getId()] = $taxClass->getName();
        }

        $taxClassSchema = [
            'label'    => static::t('Tax class'),
            'position' => 200,
        ];
        if ($taxClasses) {
            $taxClassSchema = array_replace(
                $taxClassSchema,
                [
                    'type'              => 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',
                    'choices'           => array_flip($taxClasses),
                    'choices_as_values' => true,
                    'placeholder'       => static::t('Default'),
                ]
            );
        } else {
            $taxClassSchema = array_replace(
                $taxClassSchema,
                [
                    'type'    => 'XLite\View\FormModel\Type\CaptionType',
                    'caption' => static::t('Default'),
                ]
            );
        }

        xdebug_break();
        $currency       = \XLite::getInstance()->getCurrency();
        $currencySymbol = $currency->getCurrencySymbol(false);

        $weightFormat           = \XLite\Core\Config::getInstance()->Units->weight_format;
        $weightFormatDelimiters = \XLite\View\FormField\Select\FloatFormat::getDelimiters($weightFormat);

        $inventoryTrackingDescription = $this->getDataObject()->default->identity ? $this->getWidget([
            'template' => 'form_model/product/info/inventory_tracking_description.twig',
        ])->getContent() : '';

        $product = \XLite\Core\Database::getRepo('XLite\Model\Product')->find($this->getDataObject()->default->identity);

        /**
         * Edit End
         */


        $schema = [
            self::SECTION_DEFAULT => [
                'sku'                => [
                    'label'       => static::t('SKU'),
                    'constraints' => [
                        'XLite\Core\Validator\Constraints\MaxLength' => [
                            'length'  => $skuMaxLength,
                            'message' =>
                                static::t('SKU length must be less then {{length}}', ['length' => $skuMaxLength + 1]),
                        ],
                    ],
                    'position'    => 100,
                ],
                'available_for_sale' => [
                    'label'    => static::t('Available for sale'),
                    'type'     => 'XLite\View\FormModel\Type\SwitcherType',
                    'position' => 200,
                ],
                'arrival_date'       => [
                    'label'    => static::t('Arrival date'),
                    'type'     => 'XLite\View\FormModel\Type\DatepickerType',
                    'position' => 300,
                ],
                'memberships'        => [
                    'label'             => static::t('Memberships'),
                    'type'              => 'XLite\View\FormModel\Type\Select2Type',
                    'multiple'          => true,
                    'choices'           => array_flip($memberships),
                    'choices_as_values' => true,
                    'position'          => 400,
                ],
                'tax_class'          => $taxClassSchema,

                'inventory_tracking' => [
                    'label'       => static::t('Inventory Tracking'),
                    'type'     => 'XLite\View\FormModel\Type\SwitcherType',
                    'position' => 600,
                ],
                'quantity'      => [
                    'label'     => static::t('Quantity in stock'),
                    'type'      => 'XLite\View\FormModel\Type\PatternType',
                    'pattern'   => [
                        'alias'      => 'integer',
                        'rightAlign' => false,
                    ],
                    'show_when' => [
                        'prices_and_inventory' => [
                            'inventory_tracking' => [
                                'inventory_tracking' => '1',
                            ],
                        ],
                    ],
                    'position'  => 700,
                ],

            ],
            'shipping'             => [
                'weight'            => [
                    'label'    => static::t('Weight'),
                    'type'     => 'XLite\View\FormModel\Type\SymbolType',
                    'symbol'   => \XLite\Core\Config::getInstance()->Units->weight_symbol,
                    'pattern'  => [
                        'alias'          => 'xcdecimal',
                        'digitsOptional' => false,
                        'rightAlign'     => false,
                        'digits'         => 4,
                    ],
                    'position' => 800,
                ],
                'requires_shipping' => [
                    'label'    => static::t('Requires shipping'),
                    'type'     => 'XLite\View\FormModel\Type\SwitcherType',
                    'position' => 900,
                ],
                'shipping_box'      => [
                    'type'      => 'XLite\View\FormModel\Type\Base\CompositeType',
                    'fields'    => [
                        'separate_box' => [
                            'label'    => static::t('Separate box'),
                            'type'     => 'Symfony\Component\Form\Extension\Core\Type\CheckboxType',
                            'position' => 100,
                        ],
                        'dimensions'   => [
                            'label'     => static::t('Length x Width x Height (in)'),
                            'type'      => 'XLite\View\FormModel\Type\DimensionsType',
                            'show_when' => [
                                'shipping' => [
                                    'shipping_box' => [
                                        'separate_box' => 1,
                                    ],
                                ],
                            ],
                            'position'  => 200,
                        ],
                    ],
                    'show_when' => [
                        'shipping' => [
                            'requires_shipping' => '1',
                        ],
                    ],
                    'position'  => 1000,
                ],
                'items_in_box'      => [
                    'type'      => 'XLite\View\FormModel\Type\Base\CompositeType',
                    'fields'    => [
                        'items_in_box' => [
                            'label'            => static::t('Maximum items in box'),
                            'show_label_block' => true,
                            'show_when'        => [
                                'shipping' => [
                                    'shipping_box' => [
                                        'separate_box' => 1,
                                    ],
                                ],
                            ],
                            'position'         => 100,
                        ],
                    ],
                    'show_when' => [
                        'shipping' => [
                            'requires_shipping' => '1',
                        ],
                    ],
                    'position'  => 1100,
                ],
            ],
            'marketing'            => [
                'meta_description_type' => [
                    'label'             => static::t('Meta description'),
                    'type'              => 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',
                    'choices'           => array_flip([
                        'A' => static::t('Autogenerated'),
                        'C' => static::t('Custom'),
                    ]),
                    'choices_as_values' => true,
                    'placeholder'       => false,
                    'position'          => 1200,
                ],
                'meta_description'      => [
                    'label'              => ' ',
                    'type'               => 'XLite\View\FormModel\Type\MetaDescriptionType',
                    'required'           => true,
                    'constraints'        => [
                        'XLite\Core\Validator\Constraints\MetaDescription' => [
                            'message'          => static::t('This field is required'),
                            'dependency'       => 'form.marketing.meta_description_type',
                            'dependency_value' => 'C',
                        ],
                    ],
                    'validation_trigger' => 'form.marketing.meta_description_type',
                    'show_when'          => [
                        'marketing' => [
                            'meta_description_type' => 'C',
                        ],
                    ],
                    'position'           => 1300,
                ],
                'meta_keywords'         => [
                    'label'    => static::t('Meta keywords'),
                    'position' => 1400,
                ],
                'product_page_title'    => [
                    'label'       => static::t('Product page title'),
                    'description' => static::t('Leave blank to use product name as Page Title.'),
                    'position'    => 1500,
                ],
            ],
        ];

        xdebug_break();
        return $schema;
    }



    /**
     * @return string
     */
    protected function getViewObjectGetterName()
    {
        xdebug_break();
        return 'getShippingMarketingFormModelObject';
    }

    /**
     * @return string
     */
    protected function getViewDataGetterName()
    {
        xdebug_break();
        return 'getShippingMarketingFormModelData';
    }
}
