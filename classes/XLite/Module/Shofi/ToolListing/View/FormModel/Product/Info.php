<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\Shofi\ToolListing\View\FormModel\Product;

/**
 * Product form model
 */
class Info extends \XLite\View\FormModel\AFormModel
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
        return 'update';
    }

    /**
     * @return array
     */
    protected function getActionParams()
    {
        $identity = $this->getDataObject()->default->identity;

        return $identity ? ['product_id' => $identity] : [];
    }

    /**
     * @return array
     */
    protected function defineSections()
    {
xdebug_break();
        return array_replace(parent::defineSections(), [
            'additionalInfoSection' => [
                'label'    => static::t('ADD MORE INFORMATION'),
                'position' => 100,
                'collapse'    => true,
                'expanded'    => false,
            ],
            'prices_and_inventory' => [
                'label'    => static::t('Prices & Inventory'),
                'position' => 150,
            ],
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
        $skuMaxLength  = \XLite\Core\Database::getRepo('XLite\Model\Product')->getFieldInfo('sku', 'length');
        $nameMaxLength = \XLite\Core\Database::getRepo('XLite\Model\ProductTranslation')->getFieldInfo('name', 'length');

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

        $currency       = \XLite::getInstance()->getCurrency();
        $currencySymbol = $currency->getCurrencySymbol(false);

        $weightFormat           = \XLite\Core\Config::getInstance()->Units->weight_format;
        $weightFormatDelimiters = \XLite\View\FormField\Select\FloatFormat::getDelimiters($weightFormat);

        $inventoryTrackingDescription = $this->getDataObject()->default->identity ? $this->getWidget([
            'template' => 'form_model/product/info/inventory_tracking_description.twig',
        ])->getContent() : '';

        $product = \XLite\Core\Database::getRepo('XLite\Model\Product')->find($this->getDataObject()->default->identity);
        $images = [];

        if ($product) {
            $images = $product->getImages();
        }

        $schema = [
            self::SECTION_DEFAULT  => [
                'name'               => [
                    'label'       => static::t('Product name'),
                    'required'    => true,
                    'constraints' => [
                        'Symfony\Component\Validator\Constraints\NotBlank' => [
                            'message' => static::t('This field is required'),
                        ],
                        'XLite\Core\Validator\Constraints\MaxLength'       => [
                            'length'  => $nameMaxLength,
                            'message' =>
                                static::t('Name length must be less then {{length}}', ['length' => $nameMaxLength + 1]),
                        ],
                    ],
                    'position'    => 100,
                ],
                'images'             => [
                    'label'        => static::t('Images'),
                    'type'         => 'XLite\View\FormModel\Type\OldType',
                    'oldType'      => 'XLite\View\FormField\FileUploader\Image',
                    'fieldOptions' => ['value' => $images, 'multiple' => true],
                    'position'     => 300,
                ],
                'category'           => [
                    'label'       => static::t('Category'),
                    'description' => static::t('Switch to Category tree'),
                    'type'        => 'XLite\View\FormModel\Type\ProductCategoryType',
                    'multiple'    => true,
                    'show_when' => [
                        'default' => [
                            'category_widget_type' => 'search',
                        ],
                    ],
                    'position'    => 400,
                ],
                'category_tree'      => [
                    'label'       => static::t('Category'),
                    'description' => static::t('Switch to Category search'),
                    'type'        => 'XLite\View\FormModel\Type\ProductCategoryTreeType',
                    'multiple'    => true,
                    'show_when' => [
                        'default' => [
                            'category_widget_type' => 'tree',
                        ],
                    ],
                    'position'    => 450,
                ],
                'category_widget_type' => [
                    'type' => 'Symfony\Component\Form\Extension\Core\Type\HiddenType',
                ],
                'description'               => [
                    'label'       => static::t('Short Description'),
                    'required'    => false,
                    'constraints' => [
                        'XLite\Core\Validator\Constraints\MaxLength'       => [
                            'length'  => $nameMaxLength+100,
                            'message' =>
                                static::t('Name length must be less then {{length}}', ['length' => $nameMaxLength + 1]),
                        ],
                    ],
                    'position'    => 500,
                ],
                'full_description'   => [
                    'label'    => static::t('Full description'),
                    'type'     => 'XLite\View\FormModel\Type\TextareaAdvancedType',
                    'position' => 600,
                ],

            ],
            'additionalInfoSection' => [
                'brand'               => [
                    'label'       => static::t('Product Brand'),
                    'required'    => false,
                    'constraints' => [
                        'XLite\Core\Validator\Constraints\MaxLength'       => [
                            'length'  => $nameMaxLength+100,
                            'message' =>
                                static::t('Name length must be less then {{length}}', ['length' => $nameMaxLength + 1]),
                        ],
                    ],
                    'position'    => 100,
                ],
                'model'               => [
                    'label'       => static::t('Product Model'),
                    'required'    => false,
                    'constraints' => [
                        'XLite\Core\Validator\Constraints\MaxLength'       => [
                            'length'  => $nameMaxLength+100,
                            'message' =>
                                static::t('Name length must be less then {{length}}', ['length' => $nameMaxLength + 1]),
                        ],
                    ],
                    'position'    => 200,
                ],
                'power_source'               => [
                    'label'       => static::t('Power Source'),
                    'required'    => false,
                    'constraints' => [
                        'XLite\Core\Validator\Constraints\MaxLength'       => [
                            'length'  => $nameMaxLength+100,
                            'message' =>
                                static::t('Name length must be less then {{length}}', ['length' => $nameMaxLength + 1]),
                        ],
                    ],
                    'position'    => 300,
                ],
                'condition'               => [
                    'label'       => static::t('Condition Of Your Tool'),
                    'required'    => false,
                    'constraints' => [
                        'XLite\Core\Validator\Constraints\MaxLength'       => [
                            'length'  => $nameMaxLength+100,
                            'message' =>
                                static::t('Name length must be less then {{length}}', ['length' => $nameMaxLength + 1]),
                        ],
                    ],
                    'position'    => 400,
                ],
                'additional_details'   => [
                    'label'    => static::t('Additional Components Description'),
                    'type'     => 'XLite\View\FormModel\Type\TextareaAdvancedType',
                    'position' => 500,
                ],
            ],
            'prices_and_inventory' => [
                'price'              => [
                    'label'       => static::t('Price'),
                    'type'        => 'XLite\View\FormModel\Type\SymbolType',
                    'symbol'      => $currencySymbol,
                    'pattern'     => [
                        'alias'      => 'xcdecimal',
                        'prefix'     => '',
                        'rightAlign' => false,
                        'digits'     => $currency->getE(),
                    ],
                    'constraints' => [
                        'Symfony\Component\Validator\Constraints\GreaterThanOrEqual' => [
                            'value'   => 0,
                            'message' => static::t('Minimum value is X', ['value' => 0]),
                        ],
                    ],
                    'position'    => 300,
                ],
                'tool_value'              => [
                    'label'       => static::t('Tool Value'),
                    'type'        => 'XLite\View\FormModel\Type\SymbolType',
                    'symbol'      => $currencySymbol,
                    'pattern'     => [
                        'alias'      => 'xcdecimal',
                        'prefix'     => '',
                        'rightAlign' => false,
                        'digits'     => $currency->getE(),
                    ],
                    'constraints' => [
                        'Symfony\Component\Validator\Constraints\GreaterThanOrEqual' => [
                            'value'   => 0,
                            'message' => static::t('Minimum value is X', ['value' => 0]),
                        ],
                    ],
                    'position'    => 310,
                ],
                'daily_price'              => [
                    'label'       => static::t('Daily Price'),
                    'type'        => 'XLite\View\FormModel\Type\SymbolType',
                    'symbol'      => $currencySymbol,
                    'pattern'     => [
                        'alias'      => 'xcdecimal',
                        'prefix'     => '',
                        'rightAlign' => false,
                        'digits'     => $currency->getE(),
                    ],
                    'constraints' => [
                        'Symfony\Component\Validator\Constraints\GreaterThanOrEqual' => [
                            'value'   => 0,
                            'message' => static::t('Minimum value is X', ['value' => 0]),
                        ],
                    ],
                    'position'    => 320,
                ],
                'weekly_price'              => [
                    'label'       => static::t('Weekly Price'),
                    'type'        => 'XLite\View\FormModel\Type\SymbolType',
                    'symbol'      => $currencySymbol,
                    'pattern'     => [
                        'alias'      => 'xcdecimal',
                        'prefix'     => '',
                        'rightAlign' => false,
                        'digits'     => $currency->getE(),
                    ],
                    'constraints' => [
                        'Symfony\Component\Validator\Constraints\GreaterThanOrEqual' => [
                            'value'   => 0,
                            'message' => static::t('Minimum value is X', ['value' => 0]),
                        ],
                    ],
                    'position'    => 330,
                ],
                'bond'              => [
                    'label'       => static::t('Bond Money'),
                    'type'        => 'XLite\View\FormModel\Type\SymbolType',
                    'symbol'      => $currencySymbol,
                    'pattern'     => [
                        'alias'      => 'xcdecimal',
                        'prefix'     => '',
                        'rightAlign' => false,
                        'digits'     => $currency->getE(),
                    ],
                    'constraints' => [
                        'Symfony\Component\Validator\Constraints\GreaterThanOrEqual' => [
                            'value'   => 0,
                            'message' => static::t('Minimum value is X', ['value' => 0]),
                        ],
                    ],
                    'position'    => 340,
                ],
                'gurantee_fee'              => [
                    'label'       => static::t('Gaurantee Fee'),
                    'type'        => 'XLite\View\FormModel\Type\SymbolType',
                    'symbol'      => $currencySymbol,
                    'pattern'     => [
                        'alias'      => 'xcdecimal',
                        'prefix'     => '',
                        'rightAlign' => false,
                        'digits'     => $currency->getE(),
                    ],
                    'constraints' => [
                        'Symfony\Component\Validator\Constraints\GreaterThanOrEqual' => [
                            'value'   => 0,
                            'message' => static::t('Minimum value is X', ['value' => 0]),
                        ],
                    ],
                    'position'    => 350,
                ],
            ],

            'marketing'            => [
                'clean_url'             => [
                    'label'           => static::t('Clean URL'),
                    'type'            => 'XLite\View\FormModel\Type\CleanURLType',
                    'extension'       => '.html',
                    'objectClassName' => 'XLite\Model\Product',
                    'objectId'        => $this->getDataObject()->default->identity,
                    'objectIdName'    => 'product_id',
                    'position'        => 500,
                ],
            ],
        ];

        return $schema;
    }

    /**
     * Return list of the "Button" widgets
     *
     * @return array
     */
    protected function getFormButtons()
    {
        $result   = parent::getFormButtons();
        $identity = $this->getDataObject()->default->identity;

        $label            = $identity ? 'Update product' : 'Add product';
        $result['submit'] = new \XLite\View\Button\Submit(
            [
                \XLite\View\Button\AButton::PARAM_LABEL    => $label,
                \XLite\View\Button\AButton::PARAM_BTN_TYPE => 'regular-main-button',
                \XLite\View\Button\AButton::PARAM_STYLE    => 'action',
            ]
        );

        if ($identity) {
            $url                     = $this->buildURL(
                'product',
                'clone',
                ['product_id' => $identity]
            );
            $result['clone-product'] = new \XLite\View\Button\Link(
                [
                    \XLite\View\Button\AButton::PARAM_LABEL => 'Clone this product',
                    \XLite\View\Button\AButton::PARAM_STYLE => 'model-button always-enabled',
                    \XLite\View\Button\Link::PARAM_LOCATION => $url,
                ]
            );

            $url                       = \XLite\Core\Converter::buildURL(
                'product',
                'preview',
                ['product_id' => $identity],
                \XLite::getCustomerScript()
            );
            $result['preview-product'] = new \XLite\View\Button\SimpleLink(
                [
                    \XLite\View\Button\AButton::PARAM_LABEL => 'Preview product page',
                    \XLite\View\Button\AButton::PARAM_STYLE => 'model-button link action',
                    \XLite\View\Button\Link::PARAM_BLANK    => true,
                    \XLite\View\Button\Link::PARAM_LOCATION => $url,
                ]
            );
        }

        return $result;
    }

    protected function getInventoryTrackingURL()
    {
        $identity = $this->getDataObject()->default->identity;

        return $this->buildURL(
            'product',
            '',
            [
                'product_id' => $identity,
                'page'       => 'inventory',
            ]
        );
    }

    /**
     * Return form theme files. Used in template.
     *
     * @return array
     */
    protected function getFormThemeFiles()
    {
        return array_values(array_merge(
            ['modules/Shofi/ToolListing/form_model/theme.twig'],
            array_filter(array_unique($this->theme))
        ));
    }

}
