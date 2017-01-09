<?php

namespace XLite\Model\Proxy\__CG__\XLite\Model;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Category extends \XLite\Model\Category implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'coupons', 'featuredProducts', 'ogMeta', 'useCustomOG', 'category_id', 'lpos', 'rpos', 'enabled', 'show_title', 'depth', 'pos', 'root_category_look', 'quickFlags', 'memberships', 'image', 'banner', 'categoryProducts', 'children', 'parent', 'flagVisible', 'cleanURLs', 'metaDescType', 'xcPendingExport', 'lastUsage', 'editLanguage', 'translations', '_previous_state');
        }

        return array('__isInitialized__', 'coupons', 'featuredProducts', 'ogMeta', 'useCustomOG', 'category_id', 'lpos', 'rpos', 'enabled', 'show_title', 'depth', 'pos', 'root_category_look', 'quickFlags', 'memberships', 'image', 'banner', 'categoryProducts', 'children', 'parent', 'flagVisible', 'cleanURLs', 'metaDescType', 'xcPendingExport', 'lastUsage', 'editLanguage', 'translations', '_previous_state');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Category $proxy) {
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
    public function addCoupons(\XLite\Module\CDev\Coupons\Model\Coupon $coupons)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addCoupons', array($coupons));

        return parent::addCoupons($coupons);
    }

    /**
     * {@inheritDoc}
     */
    public function getCoupons()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCoupons', array());

        return parent::getCoupons();
    }

    /**
     * {@inheritDoc}
     */
    public function getFeaturedProductsCount()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFeaturedProductsCount', array());

        return parent::getFeaturedProductsCount();
    }

    /**
     * {@inheritDoc}
     */
    public function addFeaturedProducts(\XLite\Module\CDev\FeaturedProducts\Model\FeaturedProduct $featuredProducts)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addFeaturedProducts', array($featuredProducts));

        return parent::addFeaturedProducts($featuredProducts);
    }

    /**
     * {@inheritDoc}
     */
    public function getFeaturedProducts()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFeaturedProducts', array());

        return parent::getFeaturedProducts();
    }

    /**
     * {@inheritDoc}
     */
    public function getOpenGraphMetaTags($preprocessed = true)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOpenGraphMetaTags', array($preprocessed));

        return parent::getOpenGraphMetaTags($preprocessed);
    }

    /**
     * {@inheritDoc}
     */
    public function setOgMeta($ogMeta)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOgMeta', array($ogMeta));

        return parent::setOgMeta($ogMeta);
    }

    /**
     * {@inheritDoc}
     */
    public function getOgMeta()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOgMeta', array());

        return parent::getOgMeta();
    }

    /**
     * {@inheritDoc}
     */
    public function setUseCustomOG($useCustomOG)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUseCustomOG', array($useCustomOG));

        return parent::setUseCustomOG($useCustomOG);
    }

    /**
     * {@inheritDoc}
     */
    public function getUseCustomOG()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUseCustomOG', array());

        return parent::getUseCustomOG();
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setParent(\XLite\Model\Category $parent = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setParent', array($parent));

        return parent::setParent($parent);
    }

    /**
     * {@inheritDoc}
     */
    public function setImage(\XLite\Model\Image\Category\Image $image = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setImage', array($image));

        return parent::setImage($image);
    }

    /**
     * {@inheritDoc}
     */
    public function hasImage()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'hasImage', array());

        return parent::hasImage();
    }

    /**
     * {@inheritDoc}
     */
    public function setBanner(\XLite\Model\Image\Category\Banner $image = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBanner', array($image));

        return parent::setBanner($image);
    }

    /**
     * {@inheritDoc}
     */
    public function hasBanner()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'hasBanner', array());

        return parent::hasBanner();
    }

    /**
     * {@inheritDoc}
     */
    public function isVisible()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isVisible', array());

        return parent::isVisible();
    }

    /**
     * {@inheritDoc}
     */
    public function getSubcategoriesCount()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSubcategoriesCount', array());

        return parent::getSubcategoriesCount();
    }

    /**
     * {@inheritDoc}
     */
    public function hasSubcategories()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'hasSubcategories', array());

        return parent::hasSubcategories();
    }

    /**
     * {@inheritDoc}
     */
    public function getSubcategories()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSubcategories', array());

        return parent::getSubcategories();
    }

    /**
     * {@inheritDoc}
     */
    public function getSiblings($hasSelf = false)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSiblings', array($hasSelf));

        return parent::getSiblings($hasSelf);
    }

    /**
     * {@inheritDoc}
     */
    public function getSiblingsFramed($maxResults, $hasSelf = false)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSiblingsFramed', array($maxResults, $hasSelf));

        return parent::getSiblingsFramed($maxResults, $hasSelf);
    }

    /**
     * {@inheritDoc}
     */
    public function getPath()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPath', array());

        return parent::getPath();
    }

    /**
     * {@inheritDoc}
     */
    public function getStringPath()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStringPath', array());

        return parent::getStringPath();
    }

    /**
     * {@inheritDoc}
     */
    public function getParentId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getParentId', array());

        return parent::getParentId();
    }

    /**
     * {@inheritDoc}
     */
    public function setParentId($parentID)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setParentId', array($parentID));

        return parent::setParentId($parentID);
    }

    /**
     * {@inheritDoc}
     */
    public function getMembershipIds()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMembershipIds', array());

        return parent::getMembershipIds();
    }

    /**
     * {@inheritDoc}
     */
    public function hasAvailableMembership()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'hasAvailableMembership', array());

        return parent::hasAvailableMembership();
    }

    /**
     * {@inheritDoc}
     */
    public function getProductsCount()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProductsCount', array());

        return parent::getProductsCount();
    }

    /**
     * {@inheritDoc}
     */
    public function getProducts(\XLite\Core\CommonCell $cnd = NULL, $countOnly = false)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProducts', array($cnd, $countOnly));

        return parent::getProducts($cnd, $countOnly);
    }

    /**
     * {@inheritDoc}
     */
    public function hasProduct($product)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'hasProduct', array($product));

        return parent::hasProduct($product);
    }

    /**
     * {@inheritDoc}
     */
    public function countProducts(\XLite\Core\CommonCell $cnd = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'countProducts', array($cnd));

        return parent::countProducts($cnd);
    }

    /**
     * {@inheritDoc}
     */
    public function getViewDescription()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getViewDescription', array());

        return parent::getViewDescription();
    }

    /**
     * {@inheritDoc}
     */
    public function getPosition()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPosition', array());

        return parent::getPosition();
    }

    /**
     * {@inheritDoc}
     */
    public function setPosition($position)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPosition', array($position));

        return parent::setPosition($position);
    }

    /**
     * {@inheritDoc}
     */
    public function getMetaDesc()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMetaDesc', array());

        return parent::getMetaDesc();
    }

    /**
     * {@inheritDoc}
     */
    public function getMetaDescType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMetaDescType', array());

        return parent::getMetaDescType();
    }

    /**
     * {@inheritDoc}
     */
    public function getCategoryId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCategoryId', array());

        return parent::getCategoryId();
    }

    /**
     * {@inheritDoc}
     */
    public function setLpos($lpos)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLpos', array($lpos));

        return parent::setLpos($lpos);
    }

    /**
     * {@inheritDoc}
     */
    public function getLpos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLpos', array());

        return parent::getLpos();
    }

    /**
     * {@inheritDoc}
     */
    public function setRpos($rpos)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRpos', array($rpos));

        return parent::setRpos($rpos);
    }

    /**
     * {@inheritDoc}
     */
    public function getRpos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRpos', array());

        return parent::getRpos();
    }

    /**
     * {@inheritDoc}
     */
    public function setEnabled($enabled)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEnabled', array($enabled));

        return parent::setEnabled($enabled);
    }

    /**
     * {@inheritDoc}
     */
    public function getEnabled()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEnabled', array());

        return parent::getEnabled();
    }

    /**
     * {@inheritDoc}
     */
    public function setShowTitle($showTitle)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setShowTitle', array($showTitle));

        return parent::setShowTitle($showTitle);
    }

    /**
     * {@inheritDoc}
     */
    public function getShowTitle()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getShowTitle', array());

        return parent::getShowTitle();
    }

    /**
     * {@inheritDoc}
     */
    public function setDepth($depth)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDepth', array($depth));

        return parent::setDepth($depth);
    }

    /**
     * {@inheritDoc}
     */
    public function getDepth()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDepth', array());

        return parent::getDepth();
    }

    /**
     * {@inheritDoc}
     */
    public function setPos($pos)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPos', array($pos));

        return parent::setPos($pos);
    }

    /**
     * {@inheritDoc}
     */
    public function getPos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPos', array());

        return parent::getPos();
    }

    /**
     * {@inheritDoc}
     */
    public function setRootCategoryLook($rootCategoryLook)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRootCategoryLook', array($rootCategoryLook));

        return parent::setRootCategoryLook($rootCategoryLook);
    }

    /**
     * {@inheritDoc}
     */
    public function getRootCategoryLook()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRootCategoryLook', array());

        return parent::getRootCategoryLook();
    }

    /**
     * {@inheritDoc}
     */
    public function setMetaDescType($metaDescType)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMetaDescType', array($metaDescType));

        return parent::setMetaDescType($metaDescType);
    }

    /**
     * {@inheritDoc}
     */
    public function setXcPendingExport($xcPendingExport)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setXcPendingExport', array($xcPendingExport));

        return parent::setXcPendingExport($xcPendingExport);
    }

    /**
     * {@inheritDoc}
     */
    public function getXcPendingExport()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getXcPendingExport', array());

        return parent::getXcPendingExport();
    }

    /**
     * {@inheritDoc}
     */
    public function setQuickFlags(\XLite\Model\Category\QuickFlags $quickFlags = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setQuickFlags', array($quickFlags));

        return parent::setQuickFlags($quickFlags);
    }

    /**
     * {@inheritDoc}
     */
    public function getQuickFlags()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getQuickFlags', array());

        return parent::getQuickFlags();
    }

    /**
     * {@inheritDoc}
     */
    public function addMemberships(\XLite\Model\Membership $memberships)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addMemberships', array($memberships));

        return parent::addMemberships($memberships);
    }

    /**
     * {@inheritDoc}
     */
    public function getMemberships()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMemberships', array());

        return parent::getMemberships();
    }

    /**
     * {@inheritDoc}
     */
    public function getImage()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getImage', array());

        return parent::getImage();
    }

    /**
     * {@inheritDoc}
     */
    public function getBanner()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBanner', array());

        return parent::getBanner();
    }

    /**
     * {@inheritDoc}
     */
    public function addCategoryProducts(\XLite\Model\CategoryProducts $categoryProducts)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addCategoryProducts', array($categoryProducts));

        return parent::addCategoryProducts($categoryProducts);
    }

    /**
     * {@inheritDoc}
     */
    public function getCategoryProducts()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCategoryProducts', array());

        return parent::getCategoryProducts();
    }

    /**
     * {@inheritDoc}
     */
    public function addChildren(\XLite\Model\Category $children)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addChildren', array($children));

        return parent::addChildren($children);
    }

    /**
     * {@inheritDoc}
     */
    public function getChildren()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getChildren', array());

        return parent::getChildren();
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getParent', array());

        return parent::getParent();
    }

    /**
     * {@inheritDoc}
     */
    public function addCleanURLs(\XLite\Model\CleanURL $cleanURLs)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addCleanURLs', array($cleanURLs));

        return parent::addCleanURLs($cleanURLs);
    }

    /**
     * {@inheritDoc}
     */
    public function getCleanURLs()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCleanURLs', array());

        return parent::getCleanURLs();
    }

    /**
     * {@inheritDoc}
     */
    public function updateLastUsage()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'updateLastUsage', array());

        return parent::updateLastUsage();
    }

    /**
     * {@inheritDoc}
     */
    public function generateCleanURL()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'generateCleanURL', array());

        return parent::generateCleanURL();
    }

    /**
     * {@inheritDoc}
     */
    public function setCleanURLs($cleanURLs)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCleanURLs', array($cleanURLs));

        return parent::setCleanURLs($cleanURLs);
    }

    /**
     * {@inheritDoc}
     */
    public function setCleanURL($cleanURL, $force = false)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCleanURL', array($cleanURL, $force));

        return parent::setCleanURL($cleanURL, $force);
    }

    /**
     * {@inheritDoc}
     */
    public function getCleanURL()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCleanURL', array());

        return parent::getCleanURL();
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
    public function setEditLanguage($code)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEditLanguage', array($code));

        return parent::setEditLanguage($code);
    }

    /**
     * {@inheritDoc}
     */
    public function getTranslations()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTranslations', array());

        return parent::getTranslations();
    }

    /**
     * {@inheritDoc}
     */
    public function addTranslations(\XLite\Model\Base\Translation $translation)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addTranslations', array($translation));

        return parent::addTranslations($translation);
    }

    /**
     * {@inheritDoc}
     */
    public function getTranslation($code = NULL, $allowEmptyResult = false)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTranslation', array($code, $allowEmptyResult));

        return parent::getTranslation($code, $allowEmptyResult);
    }

    /**
     * {@inheritDoc}
     */
    public function getHardTranslation($code = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHardTranslation', array($code));

        return parent::getHardTranslation($code);
    }

    /**
     * {@inheritDoc}
     */
    public function getSoftTranslation($code = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSoftTranslation', array($code));

        return parent::getSoftTranslation($code);
    }

    /**
     * {@inheritDoc}
     */
    public function hasTranslation($code = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'hasTranslation', array($code));

        return parent::hasTranslation($code);
    }

    /**
     * {@inheritDoc}
     */
    public function getTranslationCodes()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTranslationCodes', array());

        return parent::getTranslationCodes();
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
    public function cloneEntity()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'cloneEntity', array());

        return parent::cloneEntity();
    }

    /**
     * {@inheritDoc}
     */
    public function __call($method, array $arguments = array (
))
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, '__call', array($method, $arguments));

        return parent::__call($method, $arguments);
    }

    /**
     * {@inheritDoc}
     */
    public function hasMagicMethod($method)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'hasMagicMethod', array($method));

        return parent::hasMagicMethod($method);
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
