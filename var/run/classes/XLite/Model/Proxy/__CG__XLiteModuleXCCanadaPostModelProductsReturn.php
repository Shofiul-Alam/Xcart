<?php

namespace XLite\Model\Proxy\__CG__\XLite\Module\XC\CanadaPost\Model;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class ProductsReturn extends \XLite\Module\XC\CanadaPost\Model\ProductsReturn implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'id', 'items', 'links', 'order', 'status', 'oldStatus', 'date', 'lastRenewDate', 'notes', 'adminNotes', 'trackingPin', 'apiCallErrors', '_previous_state');
        }

        return array('__isInitialized__', 'id', 'items', 'links', 'order', 'status', 'oldStatus', 'date', 'lastRenewDate', 'notes', 'adminNotes', 'trackingPin', 'apiCallErrors', '_previous_state');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (ProductsReturn $proxy) {
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
    public function setOldStatus($value)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOldStatus', array($value));

        return parent::setOldStatus($value);
    }

    /**
     * {@inheritDoc}
     */
    public function setOrder(\XLite\Model\Order $order = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOrder', array($order));

        return parent::setOrder($order);
    }

    /**
     * {@inheritDoc}
     */
    public function addItem(\XLite\Module\XC\CanadaPost\Model\ProductsReturn\Item $newItem)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addItem', array($newItem));

        return parent::addItem($newItem);
    }

    /**
     * {@inheritDoc}
     */
    public function addLink(\XLite\Module\XC\CanadaPost\Model\ProductsReturn\Link $newLink)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addLink', array($newLink));

        return parent::addLink($newLink);
    }

    /**
     * {@inheritDoc}
     */
    public function getNumber()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNumber', array());

        return parent::getNumber();
    }

    /**
     * {@inheritDoc}
     */
    public function setStatus($value)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatus', array($value));

        return parent::setStatus($value);
    }

    /**
     * {@inheritDoc}
     */
    public function canBeApproved()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'canBeApproved', array());

        return parent::canBeApproved();
    }

    /**
     * {@inheritDoc}
     */
    public function canBeRejected()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'canBeRejected', array());

        return parent::canBeRejected();
    }

    /**
     * {@inheritDoc}
     */
    public function prepareBeforeSave()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'prepareBeforeSave', array());

        return parent::prepareBeforeSave();
    }

    /**
     * {@inheritDoc}
     */
    public function getItemsTotalAmount()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getItemsTotalAmount', array());

        return parent::getItemsTotalAmount();
    }

    /**
     * {@inheritDoc}
     */
    public function getItemsTotalCost()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getItemsTotalCost', array());

        return parent::getItemsTotalCost();
    }

    /**
     * {@inheritDoc}
     */
    public function getItemsTotalWeight()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getItemsTotalWeight', array());

        return parent::getItemsTotalWeight();
    }

    /**
     * {@inheritDoc}
     */
    public function hasLinks()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'hasLinks', array());

        return parent::hasLinks();
    }

    /**
     * {@inheritDoc}
     */
    public function getReturnLabelLink()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getReturnLabelLink', array());

        return parent::getReturnLabelLink();
    }

    /**
     * {@inheritDoc}
     */
    public function getLinkByRel($rel)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLinkByRel', array($rel));

        return parent::getLinkByRel($rel);
    }

    /**
     * {@inheritDoc}
     */
    public function getApiCallErrors()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getApiCallErrors', array());

        return parent::getApiCallErrors();
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatus', array());

        return parent::getStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function setDate($date)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDate', array($date));

        return parent::setDate($date);
    }

    /**
     * {@inheritDoc}
     */
    public function getDate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDate', array());

        return parent::getDate();
    }

    /**
     * {@inheritDoc}
     */
    public function setLastRenewDate($lastRenewDate)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLastRenewDate', array($lastRenewDate));

        return parent::setLastRenewDate($lastRenewDate);
    }

    /**
     * {@inheritDoc}
     */
    public function getLastRenewDate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLastRenewDate', array());

        return parent::getLastRenewDate();
    }

    /**
     * {@inheritDoc}
     */
    public function setNotes($notes)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNotes', array($notes));

        return parent::setNotes($notes);
    }

    /**
     * {@inheritDoc}
     */
    public function getNotes()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNotes', array());

        return parent::getNotes();
    }

    /**
     * {@inheritDoc}
     */
    public function setAdminNotes($adminNotes)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAdminNotes', array($adminNotes));

        return parent::setAdminNotes($adminNotes);
    }

    /**
     * {@inheritDoc}
     */
    public function getAdminNotes()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAdminNotes', array());

        return parent::getAdminNotes();
    }

    /**
     * {@inheritDoc}
     */
    public function setTrackingPin($trackingPin)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTrackingPin', array($trackingPin));

        return parent::setTrackingPin($trackingPin);
    }

    /**
     * {@inheritDoc}
     */
    public function getTrackingPin()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTrackingPin', array());

        return parent::getTrackingPin();
    }

    /**
     * {@inheritDoc}
     */
    public function addItems(\XLite\Module\XC\CanadaPost\Model\ProductsReturn\Item $items)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addItems', array($items));

        return parent::addItems($items);
    }

    /**
     * {@inheritDoc}
     */
    public function getItems()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getItems', array());

        return parent::getItems();
    }

    /**
     * {@inheritDoc}
     */
    public function addLinks(\XLite\Module\XC\CanadaPost\Model\ProductsReturn\Link $links)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addLinks', array($links));

        return parent::addLinks($links);
    }

    /**
     * {@inheritDoc}
     */
    public function getLinks()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLinks', array());

        return parent::getLinks();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOrder', array());

        return parent::getOrder();
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