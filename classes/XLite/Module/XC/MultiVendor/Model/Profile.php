<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model;

use Doctrine\Common\Collections\ArrayCollection;

use XLite\Core;
use XLite\Model;
use XLite\Model\Repo;
use XLite\Module\XC\MultiVendor;

/**
 * The "profile" model class
 */
class Profile extends \XLite\Model\Profile implements \XLite\Base\IDecorator
{
    /**
     * Additional status code
     */
    const STATUS_UNAPPROVED_VENDOR = 'U';

    /**
     * One-to-one relation with vendor_images table
     *
     * @var \XLite\Module\XC\MultiVendor\Model\Image\Vendor
     *
     * @OneToOne (targetEntity="XLite\Module\XC\MultiVendor\Model\Image\Vendor", mappedBy="vendor", cascade={"all"})
     */
    protected $vendorImage;

    /**
     * Qty in stock
     *
     * @var \XLite\Module\XC\MultiVendor\Model\Vendor
     *
     * @OneToOne (targetEntity="XLite\Module\XC\MultiVendor\Model\Vendor", mappedBy="profile", fetch="LAZY", cascade={"all"})
     */
    protected $vendor;

    /**
     * Clean URLs
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OneToMany (targetEntity="XLite\Model\CleanURL", mappedBy="vendor", cascade={"all"})
     * @OrderBy   ({"id" = "ASC"})
     */
    protected $cleanURLs;

    /**
     * Shipping methods
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OneToMany (targetEntity="XLite\Model\Shipping\Method", mappedBy="vendor", cascade={"all"})
     */
    protected $shippingMethods;

    /**
     * Vendor config
     *
     * @var string
     *
     * @Column (type="array", nullable=true)
     */
    protected $vendorConfig = array();

    /**
     * Paypal login status
     */
    const PAYPAL_LOGIN_NOT_EXISTS         = 'N';
    const PAYPAL_LOGIN_EXIST_NOT_VERIFIED = 'E';
    const PAYPAL_LOGIN_VERIFIED           = 'V';
    const PAYPAL_LOGIN_FORCE_VERIFIED     = 'F';

    /**
     * Paypal login (email)
     *
     * @var string
     *
     * @Column (type="string", unique=true, nullable=true)
     */
    protected $paypalLogin;

    /**
     * Paypal login (email)
     *
     * @var string
     *
     * @Column (type="string", nullable=true)
     */
    protected $firstName;

    /**
     * Paypal login (email)
     *
     * @var string
     *
     * @Column (type="string", nullable=true)
     */
    protected $lastName;

    /**
     * Paypal login status
     *
     * @var string
     *
     * @Column (type="string", options={"fixed": true}, length=1)
     */
    protected $paypalLoginStatus = self::PAYPAL_LOGIN_NOT_EXISTS;

    /**
     * Bank details
     *
     * @var string
     *
     * @Column (type="text", nullable=true)
     */
    protected $bankDetails = '';

    /**
     * ProfileTransactions
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OneToMany (
     *     targetEntity="XLite\Module\XC\MultiVendor\Model\ProfileTransaction",
     *     mappedBy="profile"
     * )
     * @JoinColumn (name="profile_transaction_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $profileTransactions;

    /**
     * Last shipping id (by order vendor)
     *
     * @var array
     *
     * @Column (type="array", nullable=true)
     */
    protected $lastShippingIdByVendor = array();

    /**
     * Revshare fee value
     *
     * @var float
     *
     * @Column (type="decimal", precision=14, scale=4, nullable=true)
     */
    protected $specialRevshareFeeDst;
    
    /**
     * Revshare fee type flag
     *
     * @var boolean
     *
     * @Column (type="boolean")
     */
    protected $hasSpecialRevshareFeeDst = false;

    /**
     * Revshare fee shipping value
     *
     * @var float
     *
     * @Column (type="decimal", precision=14, scale=4, nullable=true)
     */
    protected $specialRevshareFeeShipping;

    /**
     * Revshare fee shipping type flag
     *
     * @var boolean
     *
     * @Column (type="boolean")
     */
    protected $hasSpecialRevshareFeeShipping = false;


    /**
     * Constructor
     *
     * @param array $data Entity properties OPTIONAL
     */
    public function __construct(array $data = array())
    {
        parent::__construct($data);

        $this->cleanURLs           = new ArrayCollection();
        $this->shippingMethods     = new ArrayCollection();
        $this->profileTransactions = new ArrayCollection();
    }

    /**
     * We define the revshare fee from Profile model 
     * or from the global configuration if there is none
     * 
     * @return float
     */
    public function getRevshareFeeDst()
    {
        return $this->getHasSpecialRevshareFeeDst()
            ? $this->getSpecialRevshareFeeDst()
            : $this->getGlobalRevshareFeeDst();
    }

    /**
     * We define the global revshare fee from configuration
     * 
     * @return float
     */
    protected function getGlobalRevshareFeeDst()
    {
        return \XLite\Core\Config::getInstance()->XC->MultiVendor->revshare_fee_dst;
    }
    
    /**
     * We define the revshare fee of shipping from Profile model 
     * or from the global configuration if there is none
     * 
     * @return float
     */
    public function getRevshareFeeShipping()
    {
        return $this->getHasSpecialRevshareFeeShipping()
            ? $this->getSpecialRevshareFeeShipping()
            : $this->getGlobalRevshareFeeShipping();
    }

    /**
     * We define the global revshare fee from configuration
     * 
     * @return float
     */
    protected function getGlobalRevshareFeeShipping()
    {
        return \XLite\Core\Config::getInstance()->XC->MultiVendor->revshare_fee_shipping;
    }

    /**
     * Returns assigned vendor
     *
     * @return \XLite\Module\XC\MultiVendor\Model\Vendor
     */
    public function getVendor()
    {
        if (null === $this->vendor) {
            $this->vendor = new MultiVendor\Model\Vendor();
            $this->vendor->setProfile($this);
        }

        return $this->vendor;
    }

    /**
     * Check if profile is a vendor
     *
     * @return boolean
     */
    public function isVendor()
    {
        return array_reduce($this->getRoles()->toArray(), function ($result, $role) {
            return $result || $role->isVendor();
        }, false);
    }

    /**
     * Returns vendor company name
     *
     * @return string
     */
    public function getVendorCompanyName()
    {
        return $this->getVendor()->getCompanyName();
    }

    /**
     * Set vendor company name
     *
     * @param string $value Company name
     *
     * @return void
     */
    public function setVendorCompanyName($value)
    {
        $this->getVendor()->setCompanyName($value);
    }

    /**
     * Returns vendor location
     *
     * @return string
     */
    public function getVendorLocation()
    {
        return $this->getVendor()->getLocation();
    }

    /**
     * Set vendor location
     *
     * @param string $value Location
     *
     * @return void
     */
    public function setVendorLocation($value)
    {
        $this->getVendor()->setLocation($value);
    }

    /**
     * Returns vendor description
     *
     * @return string
     */
    public function getVendorDescription()
    {
        return $this->getVendor()->getDescription();
    }

    /**
     * Set vendor description
     *
     * @param string $value Description
     *
     * @return void
     */
    public function setVendorDescription($value)
    {
        $this->getVendor()->setDescription($value);
    }

    /**
     * Return products list
     *
     * @param \XLite\Core\CommonCell $cnd       Search condition OPTIONAL
     * @param boolean                $countOnly Return items list or only its size OPTIONAL
     *
     * @return array|integer
     */
    public function getVendorProducts(\XLite\Core\CommonCell $cnd = null, $countOnly = false)
    {
        if (null === $cnd) {
            $cnd = new Core\CommonCell();
        }

        // Main condition for this search
        $cnd->{Repo\Product::P_VENDOR_ID} = $this->getProfileId();

        return Core\Database::getRepo('XLite\Model\Product')->search($cnd, $countOnly);
    }

    /**
     * Add shipping method
     *
     * @param \XLite\Model\Shipping\Method $method Sipping method
     *
     * @return void
     */
    public function addShippingMethod($method)
    {
        /** @var \Doctrine\Common\Collections\ArrayCollection $methods */
        $methods = $this->getShippingMethods();

        if (!$methods->contains($method)) {
            $methods->add($method);
        }
    }

    /**
     * Remove shipping method
     *
     * @param \XLite\Model\Shipping\Method $method Sipping method
     *
     * @return void
     */
    public function removeShippingMethod($method)
    {
        $this->getShippingMethods()->removeElement($method);
    }

    /**
     * Update unapproved vendor update timestamp (bell notification)
     *
     * @return void
     */
    public function updateBellNotification()
    {
        Core\TmpVars::getInstance()->unapprovedVendorUpdateTimestamp = LC_START_TIME;
    }

    // {{{ Clean URL

    /**
     * The main procedure to generate clean URL
     *
     * @return string
     */
    public function generateCleanURL()
    {
        /** @var \XLite\Model\Repo\CleanURL $repo */
        $repo = Core\Database::getRepo('XLite\Model\CleanURL');

        return $repo->generateCleanURL($this);
    }

    /**
     * Lifecycle callback
     *
     * @return void
     *
     * @PrePersist
     * @PreUpdate
     */
    public function prepareBeforeSave()
    {
        if ($this->isVendor()
            && Core\Converter::isEmptyString($this->getCleanURL())
        ) {
            $this->setCleanURL($this->generateCleanURL());
        }
    }

    /**
     * Set paypalLogin
     *
     * @param string $paypalLogin
     * @return Profile
     */
    public function setPaypalLogin($paypalLogin)
    {
        $paypalLogin = trim($paypalLogin);

        if (empty($paypalLogin)) {
            $paypalLogin = null;
        }

        $this->paypalLogin = $paypalLogin;
        return $this;
    }

    /**
     * Set firstName
     *
     * @param string $value
     * @return Profile
     */
    public function setFirstName($value)
    {
        $this->firstName = $value;
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $value
     * @return Profile
     */
    public function setLastName($value)
    {
        $this->lastName = $value;
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Is paypal login exist and verified
     *
     * @return boolean
     */
    public function isVerifiedPaypalLogin()
    {
        return in_array(
            $this->getPaypalLoginStatus(),
            array(
                self::PAYPAL_LOGIN_VERIFIED,
                self::PAYPAL_LOGIN_FORCE_VERIFIED,
            )
        );
    }

    /**
     * Set clean urls
     *
     * @param \Doctrine\Common\Collections\Collection|string $cleanURLs
     *
     * @return void
     */
    public function setCleanURLs($cleanURLs)
    {
        if (is_string($cleanURLs)) {
            if ($cleanURLs) {
                $this->setCleanURL($cleanURLs);
            }

        } else {
            $this->cleanURLs = $cleanURLs;
        }
    }

    /**
     * Set clean URL
     *
     * @param string $cleanURL Clean url
     *
     * @return void
     */
    public function setCleanURL($cleanURL, $force = false)
    {
        if ($cleanURL && $this->getCleanURL() !== $cleanURL) {
            $cleanURLObject = new Model\CleanURL();

            $cleanURLObject->setEntity($this);
            $cleanURLObject->setCleanURL($cleanURL);

            /** @var \XLite\Model\Repo\CleanURL $repo */
            $repo = Core\Database::getRepo('XLite\Model\CleanURL');

            if ($force || $repo->isURLUnique($cleanURL, $this)) {
                Core\Database::getEM()->persist($cleanURLObject);

                /** @var \Doctrine\Common\Collections\Collection $cleanURLs */
                $cleanURLs = $this->getCleanURLs();
                $cleanURLs->add($cleanURLObject);
            }

            $this->filterCleanURLDuplicates();
            $this->filterCleanURLHistoryLength();
        }
    }

    /**
     * Get clean URL
     *
     * @return string
     */
    public function getCleanURL()
    {
        /** @var \Doctrine\Common\Collections\Collection $cleanURLs */
        $cleanURLs = $this->getCleanURLs();

        return $cleanURLs && $cleanURLs->count()
            ? $cleanURLs->last()->getCleanURL()
            : '';
    }

    /**
     * Remove duplicates from clean url history
     *
     * @return void
     */
    protected function filterCleanURLDuplicates()
    {
        $cleanURLs = array();
        foreach (array_reverse($this->getCleanURLs()->toArray()) as $cleanURLObject) {
            if (in_array($cleanURLObject->getCleanURL(), $cleanURLs)) {
                Core\Database::getEM()->remove($cleanURLObject);
                $this->getCleanURLs()->removeElement($cleanURLObject);

            } else {
                $cleanURLs[] = $cleanURLObject->getCleanURL();
            }
        }
    }

    /**
     * Cut clean url history
     *
     * @return void
     */
    protected function filterCleanURLHistoryLength()
    {
        $count = 0;
        foreach (array_reverse($this->getCleanURLs()->toArray()) as $cleanURLObject) {
            if ($count++ >= Model\Base\Catalog::CLEAN_URL_HISTORY_LENGTH) {
                $this->getCleanURLs()->removeElement($cleanURLObject);
                Core\Database::getEM()->remove($cleanURLObject);
            }
        }
    }

    // }}}

    /**
     * Set vendorConfig
     *
     * @param array $vendorConfig
     * @return Profile
     */
    public function setVendorConfig($vendorConfig)
    {
        $this->vendorConfig = $vendorConfig;
        return $this;
    }

    /**
     * Get vendorConfig
     *
     * @return array 
     */
    public function getVendorConfig()
    {
        return $this->vendorConfig;
    }

    /**
     * Get paypalLogin
     *
     * @return string 
     */
    public function getPaypalLogin()
    {
        return $this->paypalLogin;
    }

    /**
     * Set paypalLoginStatus
     *
     * @param string $paypalLoginStatus
     * @return Profile
     */
    public function setPaypalLoginStatus($paypalLoginStatus)
    {
        $this->paypalLoginStatus = $paypalLoginStatus;
        return $this;
    }

    /**
     * Get paypalLoginStatus
     *
     * @return string 
     */
    public function getPaypalLoginStatus()
    {
        return $this->paypalLoginStatus;
    }

    /**
     * Set bankDetails
     *
     * @param text $bankDetails
     * @return Profile
     */
    public function setBankDetails($bankDetails)
    {
        $this->bankDetails = $bankDetails;
        return $this;
    }

    /**
     * Get bankDetails
     *
     * @return text 
     */
    public function getBankDetails()
    {
        return $this->bankDetails;
    }

    /**
     * Set lastShippingIdByVendor
     *
     * @param array $lastShippingIdByVendor
     * @return Profile
     */
    public function setLastShippingIdByVendor($lastShippingIdByVendor)
    {
        $this->lastShippingIdByVendor = $lastShippingIdByVendor;
        return $this;
    }

    /**
     * Get lastShippingIdByVendor
     *
     * @return array 
     */
    public function getLastShippingIdByVendor()
    {
        return $this->lastShippingIdByVendor;
    }

    /**
     * Set vendorImage
     *
     * @param \XLite\Module\XC\MultiVendor\Model\Image\Vendor $vendorImage
     * @return Profile
     */
    public function setVendorImage(\XLite\Module\XC\MultiVendor\Model\Image\Vendor $vendorImage = null)
    {
        $this->vendorImage = $vendorImage;
        return $this;
    }

    /**
     * Get vendorImage
     *
     * @return \XLite\Module\XC\MultiVendor\Model\Image\Vendor 
     */
    public function getVendorImage()
    {
        return $this->vendorImage;
    }

    /**
     * Set vendor
     *
     * @param \XLite\Module\XC\MultiVendor\Model\Vendor $vendor
     * @return Profile
     */
    public function setVendor(\XLite\Module\XC\MultiVendor\Model\Vendor $vendor = null)
    {
        $this->vendor = $vendor;
        return $this;
    }

    /**
     * Add cleanURLs
     *
     * @param \XLite\Model\CleanURL $cleanURLs
     * @return Profile
     */
    public function addCleanURLs(\XLite\Model\CleanURL $cleanURLs)
    {
        $this->cleanURLs[] = $cleanURLs;
        return $this;
    }

    /**
     * Get cleanURLs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCleanURLs()
    {
        return $this->cleanURLs;
    }

    /**
     * Add shippingMethods
     *
     * @param \XLite\Model\Shipping\Method $shippingMethods
     * @return Profile
     */
    public function addShippingMethods(\XLite\Model\Shipping\Method $shippingMethods)
    {
        $this->shippingMethods[] = $shippingMethods;
        return $this;
    }

    /**
     * Get shippingMethods
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getShippingMethods()
    {
        return $this->shippingMethods;
    }

    /**
     * Add profileTransactions
     *
     * @param \XLite\Module\XC\MultiVendor\Model\ProfileTransaction $profileTransactions
     * @return Profile
     */
    public function addProfileTransactions(\XLite\Module\XC\MultiVendor\Model\ProfileTransaction $profileTransactions)
    {
        $this->profileTransactions[] = $profileTransactions;
        return $this;
    }

    /**
     * Get profileTransactions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProfileTransactions()
    {
        return $this->profileTransactions;
    }

    /**
     * Set specialRevshareFeeDst
     *
     * @param decimal $specialRevshareFeeDst
     * @return Profile
     */
    public function setSpecialRevshareFeeDst($specialRevshareFeeDst)
    {
        $this->specialRevshareFeeDst = $specialRevshareFeeDst;
        return $this;
    }

    /**
     * Get specialRevshareFeeDst
     *
     * @return decimal 
     */
    public function getSpecialRevshareFeeDst()
    {
        return $this->specialRevshareFeeDst;
    }

    /**
     * Set hasSpecialRevshareFeeDst
     *
     * @param boolean $hasSpecialRevshareFeeDst
     * @return Profile
     */
    public function setHasSpecialRevshareFeeDst($hasSpecialRevshareFeeDst)
    {
        $this->hasSpecialRevshareFeeDst = $hasSpecialRevshareFeeDst;
        return $this;
    }

    /**
     * Get hasSpecialRevshareFeeDst
     *
     * @return boolean 
     */
    public function getHasSpecialRevshareFeeDst()
    {
        return $this->hasSpecialRevshareFeeDst;
    }

    /**
     * Set specialRevshareFeeShipping
     *
     * @param decimal $specialRevshareFeeShipping
     * @return Profile
     */
    public function setSpecialRevshareFeeShipping($specialRevshareFeeShipping)
    {
        $this->specialRevshareFeeShipping = $specialRevshareFeeShipping;
        return $this;
    }

    /**
     * Get specialRevshareFeeShipping
     *
     * @return decimal 
     */
    public function getSpecialRevshareFeeShipping()
    {
        return $this->specialRevshareFeeShipping;
    }

    /**
     * Set hasSpecialRevshareFeeShipping
     *
     * @param boolean $hasSpecialRevshareFeeShipping
     * @return Profile
     */
    public function setHasSpecialRevshareFeeShipping($hasSpecialRevshareFeeShipping)
    {
        $this->hasSpecialRevshareFeeShipping = $hasSpecialRevshareFeeShipping;
        return $this;
    }

    /**
     * Get hasSpecialRevshareFeeShipping
     *
     * @return boolean 
     */
    public function getHasSpecialRevshareFeeShipping()
    {
        return $this->hasSpecialRevshareFeeShipping;
    }

    /**
     * Update field for search optimization
     *
     * @return void
     */
    public function updateSearchFakeField()
    {
        parent::updateSearchFakeField();

        if ($this->isVendor()) {
            $companyName = $this->getVendorCompanyName();

            if (!empty($companyName)) {
                $this->setSearchFakeField($this->getSearchFakeField() . ';' . $companyName);
            }
        }
    }
}
