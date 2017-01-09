<?php

namespace XLite\Module\Shofi\ToolListing\Model\Product;
/**
 * @Entity
 * @Table (name="product_aprice")
 */

class Aprice extends \XLite\Model\AEntity {

    /**
     * @Id
     * @GeneratedValue (strategy = "AUTO")
     * @column (type="integer")
     *
     */
    protected $id;

    /**
     * @Column (type="integer")
     */

    protected $orderby = 0;

    /**
     * @OneToOne (targetEntity = "XLite\Model\Product", inversedBy = "aprice")
     * @JoinColumn (name="product_id", referencedColumnName = "product_id")
     */
    protected $product;

    /**
     * @Column (type="float", length = 50)
     */
    protected $dailyPrice = 0.00;

    /**
     * @Column (type="float", length = 50)
     */
    protected $weeklyPrice = 0.00;

    /**
     * @Column (type="float", length = 50)
     */
    protected $bond = 0.00;

    /**
     * @Column (type="float", length = 50)
     */
    protected $toolValue = 0.00;

    /**
     * @Column (type="float", length = 50)
     */
    protected $guaranteeFee = 0.00;

    /**
     * @Column (type="boolean")
     */
    protected $guaranteeFeeActive = false;


    /**
     * Set product
     *
     * @param \XLite\Model\Product $product
     * @return Additional
     */
    public function setProduct(\XLite\Model\Product $product = null)
    {
        $this->product = $product;
    }

    /**
     * Get product
     *
     * @return \XLite\Model\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return mixed
     */
    public function getOrderby()
    {
        return $this->orderby;
    }

    /**
     * @param mixed $orderby
     */
    public function setOrderby($orderby)
    {
        $this->orderby = $orderby;
    }

    /**
     * @return mixed
     */
    public function getDailyPrice()
    {
        return $this->dailyPrice;
    }

    /**
     * @param mixed $dailyPrice
     */
    public function setDailyPrice($dailyPrice)
    {
        $this->dailyPrice = $dailyPrice;
    }

    /**
     * @return mixed
     */
    public function getWeeklyPrice()
    {
        return $this->weeklyPrice;
    }

    /**
     * @param mixed $weeklyPrice
     */
    public function setWeeklyPrice($weeklyPrice)
    {
        $this->weeklyPrice = $weeklyPrice;
    }

    /**
     * @return mixed
     */
    public function getBond()
    {
        return $this->bond;
    }

    /**
     * @param mixed $bond
     */
    public function setBond($value)
    {
        $this->bond = ($value * 20)/100;
    }

    /**
     * @return mixed
     */
    public function getToolValue()
    {
        return $this->toolValue;
    }

    /**
     * @param mixed $toolValue
     */
    public function setToolValue($toolValue)
    {
        $this->toolValue = $toolValue;
    }

    /**
     * @return mixed
     */
    public function getGuaranteeFee()
    {
        return $this->guaranteeFee;
    }

    /**
     * @param mixed $guaranteeFee
     */
    public function setGuaranteeFee($value)
    {
        $this->guaranteeFee = ($value * 5.06)/100;
    }


}

?>