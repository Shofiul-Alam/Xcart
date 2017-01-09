<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\Shofi\AdvanceRegistration\View\Model\Profile;

/**
 * \XLite\Module\Shofi\View\Model\Main
 */
class Main extends \XLite\View\Model\Profile\Main implements \XLite\Base\IDecorator
{

    /**
     * Schema of the address section
     * TODO: move to the module where this field is required:
     *   'address_type' => array(
     *       self::SCHEMA_CLASS    => '\XLite\View\FormField\Select\AddressType',
     *       self::SCHEMA_LABEL    => 'Address type',
     *       self::SCHEMA_REQUIRED => true,
     *   ),
     *
     * @var array
     */
    protected $addressSchema = array();

    /**
     * Address instance
     *
     * @var \XLite\Model\Address
     */
    protected $address = null;

    public function __construct()
    {
        parent::__construct();


        if (!$this->isLogged()) {

            $myschema = $this->mainSchema;

            $schema['address_autoComplete'] = array(
                self::SCHEMA_CLASS => '\XLite\View\FormField\Input\Text',
                static::SCHEMA_LABEL => 'Write your address here',
                static::SCHEMA_REQUIRED => false,
                static::SCHEMA_MODEL_ATTRIBUTES => array(
                    \XLite\View\FormField\Input\Base\StringInput::PARAM_MAX_LENGTH => '300',
            ),);


            $this->mainSchema = array_replace($myschema, $schema);

        }
    }


    /**
     * getAddressSchema
     *
     * @return array
     */
    protected function getAddressSchema()
    {

        $addressId = $this->getAddressId();

        foreach ($this->addressSchema as $key => $data) {
            $mainSchema[$addressId . '_' . $key] = $data;
        }

        $fields = \XLite\Core\Database::getRepo('XLite\Model\AddressField')
            ->search(new \XLite\Core\CommonCell(array('enabled' => true)));



        foreach ($fields as $field) {

            $mainSchema[$addressId . '_' . $field->getServiceName()] = array(
                static::SCHEMA_CLASS    => $field->getSchemaClass(),
                static::SCHEMA_LABEL    => $field->getName(),
                static::SCHEMA_REQUIRED => $field->getRequired(),
                static::SCHEMA_MODEL_ATTRIBUTES => array(
                    \XLite\View\FormField\Input\Base\StringInput::PARAM_MAX_LENGTH => 'length',
                ),
                \XLite\View\FormField\AFormField::PARAM_WRAPPER_CLASS => 'address-' . $field->getServiceName(),
            );
        }




        return $this->getFilteredSchemaFields($mainSchema);
    }

    /**
     * Filter schema fields
     *
     * @param array $fields Schema fields to filter
     *
     * @return array
     */
    protected function getFilteredSchemaFields($fields)
    {
        $addressId = $this->getAddressId();

        if (!isset($fields[$addressId . '_country_code'])) {
            // Country code field is disabled
            // We need to leave only one state field: selector or text field

            $deleteStateSelector = true;

            $address = $this->getModelObject();// I have create A new address Object ***********************************

            if ($address && $address->getCountry() && $address->getCountry()->hasStates()) {
                $deleteStateSelector = false;
            }

            if ($deleteStateSelector && isset($fields[$addressId . '_state_id'])) {
                unset($fields[$addressId . '_state_id']);

            } elseif (!$deleteStateSelector && isset($fields[$addressId . '_custom_state'])) {
                unset($fields[$addressId . '_custom_state']);

                if (isset($fields[$addressId . '_state_id'])) {
                    $fields[$addressId . '_state_id'][\XLite\View\FormField\Select\State::PARAM_COUNTRY] = $address->getCountry()->getCode();
                }
            }
        }

        return $fields;
    }


    /**
     * Return fields list by the corresponding schema
     *
     * @return array
     */
    public function getFormFieldsForSectionDefault()
    {
        if (!$this->isLogged() && $this->isRegisterMode()) {



            $mainSchema = $this->getFieldsBySchema($this->getAddressSchema());

            // For country <-> state synchronization
            $this->setStateSelectorIds($mainSchema);


            return $mainSchema;
        } else {
            return null;
        }

    }

    /**
     * Pass the DOM IDs of the "State" selectbox to the "CountrySelector" widget
     *
     * @param array &$fields Widgets list
     *
     * @return void
     */
    protected function setStateSelectorIds(array &$fields)
    {
        $addressId = $this->getAddressId();

        if (
            !empty($fields[$addressId . '_state_id'])
            && !empty($fields[$addressId . '_custom_state'])
            && !empty($fields[$addressId . '_country_code'])
        ) {
            $fields[$addressId . '_country_code']->setStateSelectorIds(
                $fields[$addressId . '_state_id']->getFieldId(),
                $fields[$addressId . '_custom_state']->getFieldId()
            );
        }
    }

    /**
     * Return current address ID
     *
     * @return integer
     */
    public function getAddressId()
    {
        return $this->getRequestAddressId() ?: null;
    }

    /**
     * Get address ID from request
     *
     * @return integer
     */
    public function getRequestAddressId()
    {
        return \XLite\Core\Request::getInstance()->address_id;
    }




}
