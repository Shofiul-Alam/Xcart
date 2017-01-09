<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model;

use XLite\Core;
use XLite\Module\XC\MultiVendor;

/**
 * ProfileTransaction
 *
 * @Entity
 * @Table (name="profile_transaction")
 */
class ProfileTransaction extends \XLite\Model\AEntity
{
    /**
     * Provider identifier
     */
    const PROVIDER_NO_PROVIDER = 'NN';
    const PROVIDER_PAYPAL = 'PP';

    /**
     * Id
     *
     * @var integer
     *
     * @Id
     * @GeneratedValue
     * @Column (type="integer", options={"unsigned": true})
     */
    protected $id;

    /**
     * Date
     *
     * @var \DateTime
     *
     * @Column(type="datetime")
     */
    protected $date;

    /**
     * Commission value
     *
     * @var string
     *
     * @Column (type="decimal", precision=14, scale=4, nullable=true)
     */
    protected $value;

    /**
     * Profile inversed link
     *
     * @var \XLite\Model\Profile
     *
     * @ManyToOne (
     *      targetEntity="XLite\Model\Profile",
     *      inversedBy="vendorTransactions"
     *  )
     * @JoinColumn (name="profile_id", referencedColumnName="profile_id", onDelete="CASCADE")
     */
    protected $profile;

    /**
     * Author inversed link
     *
     * @var \XLite\Model\Profile
     *
     * @ManyToOne (targetEntity="XLite\Model\Profile")
     * @JoinColumn (name="author_id", referencedColumnName="profile_id", onDelete="CASCADE")
     */
    protected $author;

    /**
     * Provider
     *
     * @var string
     *
     * @Column (type="string", options={ "fixed": true }, length=2)
     */
    protected $provider = self::PROVIDER_NO_PROVIDER;

    /**
     * Order inversed link
     *
     * @var \XLite\Model\Order
     *
     * @ManyToOne (targetEntity="XLite\Model\Order", inversedBy="profileTransactions")
     * @JoinColumn (name="order_id", referencedColumnName="order_id", onDelete="SET NULL")
     */
    protected $order;

    /**
     * Description
     *
     * @var string
     *
     * @Column (type="text")
     */
    protected $description = '';

    /**
     * Constructor
     *
     * @param array $data Entity properties OPTIONAL
     */
    public function __construct(array $data = array())
    {
        parent::__construct($data);

        $this->date = new \DateTime();
    }

    /**
     * Get order for displaying number and linking
     *
     * @return \XLite\Model\Order
     */
    public function getDisplayOrder()
    {
        return $this->getOrder() && !((bool)$this->getOrder()->getOrderNumber())
            ? $this->getOrder()->getParent()
            : $this->getOrder();
    }

    /**
     * Get provider image url
     *
     * @return string
     */
    public function getProviderImageUrl()
    {
        return MultiVendor\Model\ProfileTransaction::PROVIDER_PAYPAL === $this->getProvider()
            ? Core\Layout::getInstance()->getResourceWebPath('modules/CDev/Paypal/method_icon.png')
            : '';
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param datetime $date
     * @return ProfileTransaction
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get date
     *
     * @return datetime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set value
     *
     * @param decimal $value
     * @return ProfileTransaction
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get value
     *
     * @return decimal 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set provider
     *
     * @param string $provider
     * @return ProfileTransaction
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * Get provider
     *
     * @return string 
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set description
     *
     * @param text $description
     * @return ProfileTransaction
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set profile
     *
     * @param \XLite\Model\Profile $profile
     * @return ProfileTransaction
     */
    public function setProfile(\XLite\Model\Profile $profile = null)
    {
        $this->profile = $profile;
        return $this;
    }

    /**
     * Get profile
     *
     * @return \XLite\Model\Profile 
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set author
     *
     * @param \XLite\Model\Profile $author
     * @return ProfileTransaction
     */
    public function setAuthor(\XLite\Model\Profile $author = null)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Get author
     *
     * @return \XLite\Model\Profile 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set order
     *
     * @param \XLite\Model\Order $order
     * @return ProfileTransaction
     */
    public function setOrder(\XLite\Model\Order $order = null)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * Get order
     *
     * @return \XLite\Model\Order 
     */
    public function getOrder()
    {
        return $this->order;
    }
}
