<?php

namespace XLite\Model\Proxy\__CG__\XLite\Model;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Address extends \XLite\Model\Address implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }

    /**
     * {@inheritDoc}
     * @param string $name
     */
    public function __get($name)
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__get', array($name));

        return parent::__get($name);
    }

    /**
     * {@inheritDoc}
     * @param string $name
     * @param mixed  $value
     */
    public function __set($name, $value)
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__set', array($name, $value));

        return parent::__set($name, $value);
    }

    /**
     * {@inheritDoc}
     * @param  string $name
     * @return boolean
     */
    public function __isset($name)
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__isset', array($name));

        return parent::__isset($name);

    }

    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', 'addressFields', 'is_billing', 'is_shipping', 'isWork', 'profile', 'address_id', 'address_type', 'state', 'country', '_previous_state');
        }

        return array('__isInitialized__', 'addressFields', 'is_billing', 'is_shipping', 'isWork', 'profile', 'address_id', 'address_type', 'state', 'country', '_previous_state');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Address $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getRequiredFieldsByType($atype)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRequiredFieldsByType', array($atype));

        return parent::getRequiredFieldsByType($atype);
    }

    /**
     * {@inheritDoc}
     */
    public function setterProperty($property, $value)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setterProperty', array($property, $value));

        return parent::setterProperty($property, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function update()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'update', array());

        return parent::update();
    }

    /**
     * {@inheritDoc}
     */
    public function delete()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'delete', array());

        return parent::delete();
    }

    /**
     * {@inheritDoc}
     */
    public function create()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'create', array());

        return parent::create();
    }

    /**
     * {@inheritDoc}
     */
    public function getterProperty($property)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getterProperty', array($property));

        return parent::getterProperty($property);
    }

    /**
     * {@inheritDoc}
     */
    public function isPropertyExists($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isPropertyExists', array($name));

        return parent::isPropertyExists($name);
    }

    /**
     * {@inheritDoc}
     */
    public function getFieldValue($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFieldValue', array($name));

        return parent::getFieldValue($name);
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'serialize', array());

        return parent::serialize();
    }

    /**
     * {@inheritDoc}
     */
    public function cloneEntity()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'cloneEntity', array());

        return parent::cloneEntity();
    }

    /**
     * {@inheritDoc}
     */
    public function getCountry()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCountry', array());

        return parent::getCountry();
    }

    /**
     * {@inheritDoc}
     */
    public function setIsBilling($isBilling)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsBilling', array($isBilling));

        return parent::setIsBilling($isBilling);
    }

    /**
     * {@inheritDoc}
     */
    public function getIsBilling()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsBilling', array());

        return parent::getIsBilling();
    }

    /**
     * {@inheritDoc}
     */
    public function setIsShipping($isShipping)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsShipping', array($isShipping));

        return parent::setIsShipping($isShipping);
    }

    /**
     * {@inheritDoc}
     */
    public function getIsShipping()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsShipping', array());

        return parent::getIsShipping();
    }

    /**
     * {@inheritDoc}
     */
    public function setIsWork($isWork)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsWork', array($isWork));

        return parent::setIsWork($isWork);
    }

    /**
     * {@inheritDoc}
     */
    public function getIsWork()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsWork', array());

        return parent::getIsWork();
    }

    /**
     * {@inheritDoc}
     */
    public function getAddressId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAddressId', array());

        return parent::getAddressId();
    }

    /**
     * {@inheritDoc}
     */
    public function setAddressType($addressType)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAddressType', array($addressType));

        return parent::setAddressType($addressType);
    }

    /**
     * {@inheritDoc}
     */
    public function getAddressType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAddressType', array());

        return parent::getAddressType();
    }

    /**
     * {@inheritDoc}
     */
    public function addAddressFields(\XLite\Model\AddressFieldValue $addressFields)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addAddressFields', array($addressFields));

        return parent::addAddressFields($addressFields);
    }

    /**
     * {@inheritDoc}
     */
    public function getAddressFields()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAddressFields', array());

        return parent::getAddressFields();
    }

    /**
     * {@inheritDoc}
     */
    public function setProfile(\XLite\Model\Profile $profile = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProfile', array($profile));

        return parent::setProfile($profile);
    }

    /**
     * {@inheritDoc}
     */
    public function getProfile()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProfile', array());

        return parent::getProfile();
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getName', array());

        return parent::getName();
    }

    /**
     * {@inheritDoc}
     */
    public function setName($value)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setName', array($value));

        return parent::setName($value);
    }

    /**
     * {@inheritDoc}
     */
    public function getAvailableAddressFields()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAvailableAddressFields', array());

        return parent::getAvailableAddressFields();
    }

    /**
     * {@inheritDoc}
     */
    public function getState()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getState', array());

        return parent::getState();
    }

    /**
     * {@inheritDoc}
     */
    public function setCountryCode($countryCode)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCountryCode', array($countryCode));

        return parent::setCountryCode($countryCode);
    }

    /**
     * {@inheritDoc}
     */
    public function setCountry(\XLite\Model\Country $country = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCountry', array($country));

        return parent::setCountry($country);
    }

    /**
     * {@inheritDoc}
     */
    public function setStateId($stateId)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStateId', array($stateId));

        return parent::setStateId($stateId);
    }

    /**
     * {@inheritDoc}
     */
    public function setState($state)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setState', array($state));

        return parent::setState($state);
    }

    /**
     * {@inheritDoc}
     */
    public function getStateId($strict = false)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStateId', array($strict));

        return parent::getStateId($strict);
    }

    /**
     * {@inheritDoc}
     */
    public function getCountryCode()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCountryCode', array());

        return parent::getCountryCode();
    }

    /**
     * {@inheritDoc}
     */
    public function getCountryName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCountryName', array());

        return parent::getCountryName();
    }

    /**
     * {@inheritDoc}
     */
    public function getStateName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStateName', array());

        return parent::getStateName();
    }

    /**
     * {@inheritDoc}
     */
    public function getTypeName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTypeName', array());

        return parent::getTypeName();
    }

    /**
     * {@inheritDoc}
     */
    public function getRequiredEmptyFields($atype)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRequiredEmptyFields', array($atype));

        return parent::getRequiredEmptyFields($atype);
    }

    /**
     * {@inheritDoc}
     */
    public function isCompleted($atype)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isCompleted', array($atype));

        return parent::isCompleted($atype);
    }

    /**
     * {@inheritDoc}
     */
    public function isEqualAddress(\XLite\Model\Base\Address $address)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isEqualAddress', array($address));

        return parent::isEqualAddress($address);
    }

    /**
     * {@inheritDoc}
     */
    public function getFieldsHash()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFieldsHash', array());

        return parent::getFieldsHash();
    }

    /**
     * {@inheritDoc}
     */
    public function _getPreviousState()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, '_getPreviousState', array());

        return parent::_getPreviousState();
    }

    /**
     * {@inheritDoc}
     */
    public function map(array $data)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'map', array($data));

        return parent::map($data);
    }

    /**
     * {@inheritDoc}
     */
    public function __unset($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, '__unset', array($name));

        return parent::__unset($name);
    }

    /**
     * {@inheritDoc}
     */
    public function getRepository()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRepository', array());

        return parent::getRepository();
    }

    /**
     * {@inheritDoc}
     */
    public function checkCache()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'checkCache', array());

        return parent::checkCache();
    }

    /**
     * {@inheritDoc}
     */
    public function detach()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'detach', array());

        return parent::detach();
    }

    /**
     * {@inheritDoc}
     */
    public function __call($method, array $args = array (
))
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, '__call', array($method, $args));

        return parent::__call($method, $args);
    }

    /**
     * {@inheritDoc}
     */
    public function isPersistent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isPersistent', array());

        return parent::isPersistent();
    }

    /**
     * {@inheritDoc}
     */
    public function isDetached()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isDetached', array());

        return parent::isDetached();
    }

    /**
     * {@inheritDoc}
     */
    public function isManaged()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isManaged', array());

        return parent::isManaged();
    }

    /**
     * {@inheritDoc}
     */
    public function getUniqueIdentifierName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUniqueIdentifierName', array());

        return parent::getUniqueIdentifierName();
    }

    /**
     * {@inheritDoc}
     */
    public function getUniqueIdentifier()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUniqueIdentifier', array());

        return parent::getUniqueIdentifier();
    }

    /**
     * {@inheritDoc}
     */
    public function getEntityName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEntityName', array());

        return parent::getEntityName();
    }

    /**
     * {@inheritDoc}
     */
    public function processFiles($field, array $data)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'processFiles', array($field, $data));

        return parent::processFiles($field, $data);
    }

    /**
     * {@inheritDoc}
     */
    public function getFieldsDefinition($class = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFieldsDefinition', array($class));

        return parent::getFieldsDefinition($class);
    }

    /**
     * {@inheritDoc}
     */
    public function prepareEntityBeforeCommit($type)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'prepareEntityBeforeCommit', array($type));

        return parent::prepareEntityBeforeCommit($type);
    }

}
