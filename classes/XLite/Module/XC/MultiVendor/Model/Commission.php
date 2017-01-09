<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model;

/**
 * Commission
 *
 * @Entity
 * @Table (name="commission")
 */
class Commission extends \XLite\Model\AEntity
{
    /**
     * Commission status codes
     */

    const STATUS_PAID           = 'P';
    const STATUS_NOT_PAID       = 'N';

    /**
     * Id
     *
     * @var integer
     * 
     * @Id
     * @GeneratedValue
     * @Column         (type="integer", options={ "unsigned": true })
     */
    protected $id;

    /**
     * Commission value
     *
     * @var string
     *
     * @Column (type="decimal", precision=14, scale=4, nullable=true)
     */
    protected $value;

    /**
     * Status
     *
     * @var string
     *
     * @Column (type="string", options={ "fixed": true }, length=1)
     */
    protected $status = self::STATUS_NOT_PAID;

    /**
     * Auto paid state
     *
     * @var boolean
     *
     * @Column (type="boolean")
     */
    protected $auto = false;

    /**
     * Order inversed link
     * 
     * @var \XLite\Model\Order
     * 
     * @OneToOne (
     *      targetEntity="XLite\Model\Order",
     *      mappedBy="commission"
     *  )
     * @JoinColumn (name="order_id", referencedColumnName="order_id", onDelete="CASCADE")
     */
    protected $order;

    /**
     * Get statuses
     *
     * @return array
     */
    public static function getStatuses()
    {
        return array(
            static::STATUS_PAID         => 'Paid',
            static::STATUS_NOT_PAID     => 'Not paid',
        );
    }

    /**
     * Get order total commission (everything except shipping)
     * 
     * @return decimal
     */
    protected function getOrderCommission()
    {
        $baseShipping = $this->getOrder()->getSurchargesSubtotal(
            \XLite\Model\Base\Surcharge::TYPE_SHIPPING
        );
        $baseTotal      = $this->getOrder()->getTotal() - $baseShipping;
        $modifierTotal  = $this->getOrder()->getRevshareFeeDst() / 100;

        return $baseTotal * (1 - $modifierTotal);
    }

    /**
     * Get order base shipping
     * 
     * @return decimal
     */
    protected function getShippingCommission()
    {
        $baseShipping = $this->getOrder()->getSurchargesSubtotal(
            \XLite\Model\Base\Surcharge::TYPE_SHIPPING
        );
        $modifierShipping   = $this->getOrder()->getRevshareFeeShipping() / 100;

        return $baseShipping * (1 - $modifierShipping);
    }

    /**
     * Calculate commission value
     *
     * @return void
     */
    public function recalculate()
    {
        $this->value = $this->getOrderCommission() + $this->getShippingCommission();
        \XLite\Core\Database::getEM()->persist($this);
        \XLite\Core\Database::getEM()->flush();
    }

    /**
     * Get order for displaying number and linking
     * 
     * @return \XLite\Model\Order
     */
    public function getDisplayOrder()
    {
        return !((bool)$this->getOrder()->getOrderNumber())
            ? $this->getOrder()->getParent()
            : $this->getOrder();
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param decimal $value
     * @return Commission
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Commission
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set auto
     *
     * @param boolean $auto
     * @return Commission
     */
    public function setAuto($auto)
    {
        $this->auto = $auto;
        return $this;
    }

    /**
     * Get auto
     *
     * @return boolean 
     */
    public function getAuto()
    {
        return $this->auto;
    }

    /**
     * Set order
     *
     * @param \XLite\Model\Order $order
     * @return Commission
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
