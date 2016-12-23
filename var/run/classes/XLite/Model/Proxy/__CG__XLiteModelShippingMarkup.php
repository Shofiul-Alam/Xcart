<?php

namespace XLite\Model\Proxy\__CG__\XLite\Model\Shipping;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Markup extends \XLite\Model\Shipping\Markup implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'markup_id', 'min_weight', 'max_weight', 'min_total', 'max_total', 'min_items', 'max_items', 'markup_flat', 'markup_percent', 'markup_per_item', 'markup_per_weight', 'shipping_method', 'zone', 'markupValue', '_previous_state');
        }

        return array('__isInitialized__', 'markup_id', 'min_weight', 'max_weight', 'min_total', 'max_total', 'min_items', 'max_items', 'markup_flat', 'markup_percent', 'markup_per_item', 'markup_per_weight', 'shipping_method', 'zone', 'markupValue', '_previous_state');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Markup $proxy) {
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
    public function hasRates()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'hasRates', array());

        return parent::hasRates();
    }

    /**
     * {@inheritDoc}
     */
    public function getMarkupValue()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMarkupValue', array());

        return parent::getMarkupValue();
    }

    /**
     * {@inheritDoc}
     */
    public function setMarkupValue($value)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMarkupValue', array($value));

        return parent::setMarkupValue($value);
    }

    /**
     * {@inheritDoc}
     */
    public function getWeightRange()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getWeightRange', array());

        return parent::getWeightRange();
    }

    /**
     * {@inheritDoc}
     */
    public function setWeightRange($value)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setWeightRange', array($value));

        return parent::setWeightRange($value);
    }

    /**
     * {@inheritDoc}
     */
    public function getSubtotalRange()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSubtotalRange', array());

        return parent::getSubtotalRange();
    }

    /**
     * {@inheritDoc}
     */
    public function setSubtotalRange($value)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSubtotalRange', array($value));

        return parent::setSubtotalRange($value);
    }

    /**
     * {@inheritDoc}
     */
    public function getItemsRange()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getItemsRange', array());

        return parent::getItemsRange();
    }

    /**
     * {@inheritDoc}
     */
    public function setItemsRange($value)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setItemsRange', array($value));

        return parent::setItemsRange($value);
    }

    /**
     * {@inheritDoc}
     */
    public function getMarkupId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMarkupId', array());

        return parent::getMarkupId();
    }

    /**
     * {@inheritDoc}
     */
    public function setMinWeight($minWeight)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMinWeight', array($minWeight));

        return parent::setMinWeight($minWeight);
    }

    /**
     * {@inheritDoc}
     */
    public function getMinWeight()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMinWeight', array());

        return parent::getMinWeight();
    }

    /**
     * {@inheritDoc}
     */
    public function setMaxWeight($maxWeight)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMaxWeight', array($maxWeight));

        return parent::setMaxWeight($maxWeight);
    }

    /**
     * {@inheritDoc}
     */
    public function getMaxWeight()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMaxWeight', array());

        return parent::getMaxWeight();
    }

    /**
     * {@inheritDoc}
     */
    public function setMinTotal($minTotal)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMinTotal', array($minTotal));

        return parent::setMinTotal($minTotal);
    }

    /**
     * {@inheritDoc}
     */
    public function getMinTotal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMinTotal', array());

        return parent::getMinTotal();
    }

    /**
     * {@inheritDoc}
     */
    public function setMaxTotal($maxTotal)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMaxTotal', array($maxTotal));

        return parent::setMaxTotal($maxTotal);
    }

    /**
     * {@inheritDoc}
     */
    public function getMaxTotal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMaxTotal', array());

        return parent::getMaxTotal();
    }

    /**
     * {@inheritDoc}
     */
    public function setMinItems($minItems)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMinItems', array($minItems));

        return parent::setMinItems($minItems);
    }

    /**
     * {@inheritDoc}
     */
    public function getMinItems()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMinItems', array());

        return parent::getMinItems();
    }

    /**
     * {@inheritDoc}
     */
    public function setMaxItems($maxItems)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMaxItems', array($maxItems));

        return parent::setMaxItems($maxItems);
    }

    /**
     * {@inheritDoc}
     */
    public function getMaxItems()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMaxItems', array());

        return parent::getMaxItems();
    }

    /**
     * {@inheritDoc}
     */
    public function setMarkupFlat($markupFlat)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMarkupFlat', array($markupFlat));

        return parent::setMarkupFlat($markupFlat);
    }

    /**
     * {@inheritDoc}
     */
    public function getMarkupFlat()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMarkupFlat', array());

        return parent::getMarkupFlat();
    }

    /**
     * {@inheritDoc}
     */
    public function setMarkupPercent($markupPercent)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMarkupPercent', array($markupPercent));

        return parent::setMarkupPercent($markupPercent);
    }

    /**
     * {@inheritDoc}
     */
    public function getMarkupPercent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMarkupPercent', array());

        return parent::getMarkupPercent();
    }

    /**
     * {@inheritDoc}
     */
    public function setMarkupPerItem($markupPerItem)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMarkupPerItem', array($markupPerItem));

        return parent::setMarkupPerItem($markupPerItem);
    }

    /**
     * {@inheritDoc}
     */
    public function getMarkupPerItem()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMarkupPerItem', array());

        return parent::getMarkupPerItem();
    }

    /**
     * {@inheritDoc}
     */
    public function setMarkupPerWeight($markupPerWeight)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMarkupPerWeight', array($markupPerWeight));

        return parent::setMarkupPerWeight($markupPerWeight);
    }

    /**
     * {@inheritDoc}
     */
    public function getMarkupPerWeight()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMarkupPerWeight', array());

        return parent::getMarkupPerWeight();
    }

    /**
     * {@inheritDoc}
     */
    public function setShippingMethod(\XLite\Model\Shipping\Method $shippingMethod = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setShippingMethod', array($shippingMethod));

        return parent::setShippingMethod($shippingMethod);
    }

    /**
     * {@inheritDoc}
     */
    public function getShippingMethod()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getShippingMethod', array());

        return parent::getShippingMethod();
    }

    /**
     * {@inheritDoc}
     */
    public function setZone(\XLite\Model\Zone $zone = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setZone', array($zone));

        return parent::setZone($zone);
    }

    /**
     * {@inheritDoc}
     */
    public function getZone()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getZone', array());

        return parent::getZone();
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
    public function isPropertyExists($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isPropertyExists', array($name));

        return parent::isPropertyExists($name);
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
    public function getterProperty($property)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getterProperty', array($property));

        return parent::getterProperty($property);
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
    public function update()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'update', array());

        return parent::update();
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
    public function delete()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'delete', array());

        return parent::delete();
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
    public function cloneEntity()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'cloneEntity', array());

        return parent::cloneEntity();
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
