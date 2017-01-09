<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Model\Profile;

/**
 * Administrator profile model widget. This widget is used in the admin interface
 */
class Vendor extends \XLite\View\Model\Profile\AProfile
{
    /**
     * Schema of the "Vendor info" section
     *
     * @var array
     */
    protected $schemaDefault = array(
        'vendorCompanyName' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Company name',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_PLACEHOLDER => 'Company name',
        ),
        'hasSpecialRevshareFeeDst' => array(
            self::SCHEMA_CLASS    => 'XLite\Module\XC\MultiVendor\View\FormField\Select\RateType',
            self::SCHEMA_LABEL    => 'Order DST based commission rate defined by',
        ),
        'revshareFeeDst' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Label',
            self::SCHEMA_LABEL    => 'Order DST based commission rate of this vendor',
        ),
        'specialRevshareFeeDst' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text\FloatInput',
            self::SCHEMA_LABEL    => 'Order DST based commission rate of this vendor',
            self::SCHEMA_DEPENDENCY   => array(
                self::DEPENDENCY_SHOW     => array(
                    'hasSpecialRevshareFeeDst' => array(\XLite\Module\XC\MultiVendor\View\FormField\Select\RateType::PARAM_SPECIAL_RATE),
                ),
            ),
        ),
        'hasSpecialRevshareFeeShipping' => array(
            self::SCHEMA_CLASS    => 'XLite\Module\XC\MultiVendor\View\FormField\Select\RateType',
            self::SCHEMA_LABEL    => 'Order shipping cost based commission rate defined by',
        ),
        'revshareFeeShipping' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Label',
            self::SCHEMA_LABEL    => 'Order shipping cost based commission rate of this vendor',
        ),
        'specialRevshareFeeShipping' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text\FloatInput',
            self::SCHEMA_LABEL    => 'Order shipping cost based commission rate of this vendor',
            self::SCHEMA_DEPENDENCY   => array(
                self::DEPENDENCY_SHOW     => array(
                    'hasSpecialRevshareFeeShipping' => array(\XLite\Module\XC\MultiVendor\View\FormField\Select\RateType::PARAM_SPECIAL_RATE),
                ),
            ),
        ),
        'cleanURL' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text\CleanURL',
            self::SCHEMA_LABEL    => 'CleanURL',
            self::SCHEMA_REQUIRED => false,
            \XLite\View\FormField\AFormField::PARAM_LABEL_HELP => 'Human readable and SEO friendly web address for the page.',
            \XLite\View\FormField\Input\Text\CleanURL::PARAM_OBJECT_CLASS_NAME => 'XLite\Model\Profile',
            \XLite\View\FormField\Input\Text\CleanURL::PARAM_OBJECT_ID_NAME    => 'profile_id',
            \XLite\View\FormField\Input\Text\CleanURL::PARAM_ID                => 'cleanurl',
            \XLite\View\FormField\Input\Text\CleanURL::PARAM_EXTENSION         => \XLite\Model\Repo\CleanURL::CLEAN_URL_DEFAULT_EXTENSION,
        ),
        'vendorImage'       => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\FileUploader\Image',
            self::SCHEMA_LABEL    => 'Image',
            self::SCHEMA_REQUIRED => false,
        ),
        'vendorLocation'    => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Location',
            self::SCHEMA_REQUIRED => false,
        ),
        'vendorDescription' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Textarea\Advanced',
            self::SCHEMA_LABEL    => 'Description',
            self::SCHEMA_REQUIRED => false,
        ),
    );


    /**
     * If vendor edits own profile, commission rates have read only access
     * 
     * @param array $params   Widget params OPTIONAL
     * @param array $sections Sections list OPTIONAL
     * 
     * @return void
     */
    public function __construct(array $params = array(), array $sections = array())
    {
        parent::__construct($params, $sections);

        if (\XLite\Core\Auth::getInstance()->isVendor()) {            
            unset(
                $this->schemaDefault['hasSpecialRevshareFeeDst'], 
                $this->schemaDefault['hasSpecialRevshareFeeShipping'],
                $this->schemaDefault['specialRevshareFeeDst'],
                $this->schemaDefault['specialRevshareFeeShipping']
            );
        } else {
            unset(
                $this->schemaDefault['revshareFeeDst'],
                $this->schemaDefault['revshareFeeShipping']
            );            
        }
    }

    /**
     * Return current model ID
     *
     * @return integer
     */
    public function getModelId()
    {
        return \XLite\Core\Request::getInstance()->profile_id;
    }

    /**
     * Get model value by name
     *
     * @param \XLite\Model\AEntity $model Model object
     * @param string               $name  Property name
     *
     * @return mixed
     */
    protected function getModelValue($model, $name)
    {
        $value = parent::getModelValue($model, $name);

        if (
            \XLite\Core\Auth::getInstance()->isVendor() 
            && $this->isSpecialRatesValues($name)
        ) {
            $value .= '%';
        }

        return $value;
    }

    /**
     * Check if the provided name of the field is one of the special rates fields
     * 
     * @param string $name Name of the field
     * 
     * @return boolean
     */
    protected function isSpecialRatesValues($name)
    {
        return in_array($name, array('revshareFeeDst', 'revshareFeeShipping'));
    }
    
    /**
     * If vendor edits own profile, commission rates have read only access
     *
     * @return array
     */
    protected function prepareDataForMapping()
    {
        $data = parent::prepareDataForMapping();

        if (\XLite\Core\Auth::getInstance()->isVendor()) {
            unset($data['specialRevshareFeeDst'], $data['specialRevshareFeeShipping']);
        }

        return $data;
    }

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/XC/MultiVendor/profile/style.css';

        return $list;
    }

    /**
     * Return current profile ID
     *
     * @return integer
     */
    public function getProfileId()
    {
        return \XLite\Core\Auth::getInstance()->isVendor()
            ? \XLite\Core\Auth::getInstance()->getProfile()->getProfileId()
            : \XLite\Core\Request::getInstance()->profile_id;
    }

    /**
     * The "mode" parameter used to determine if we create new or modify existing profile
     *
     * @return boolean
     */
    public function isRegisterMode()
    {
        return false;
    }

    /**
     * This object will be used if another one is not passed
     *
     * @return \XLite\Model\Profile
     */
    protected function getDefaultModelObject()
    {
        return \XLite\Core\Database::getRepo('XLite\Model\Profile')->find($this->getProfileId());
    }

    /**
     * Return name of web form widget class
     *
     * @return string
     */
    protected function getFormClass()
    {
        return 'XLite\Module\XC\MultiVendor\View\Form\Profile\Vendor';
    }

    /**
     * Return title
     *
     * @return string
     */
    protected function getHead()
    {
        return 'Vendor details';
    }

    /**
     * Prepare customerSubject field parameters
     *
     * @param array $data Parameters
     *
     * @return array
     */
    protected function prepareFieldParamsCleanURL($data)
    {
        $data[\XLite\View\FormField\Input\Text\CleanURL::PARAM_OBJECT_ID] = $this->getProfileId();

        return $data;
    }
}
