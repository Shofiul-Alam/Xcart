<?php
/**
 * Created by PhpStorm.
 * User: Shofiul
 * Date: 5/01/2017
 * Time: 4:54 PM
 */

namespace XLite\Module\Shofi\ToolListing\Model\Product;

/**
 * @Entity
 * @Table (name = "product_extra_details")
 */


class ToolDetails extends \XLite\Model\AEntity {

    /**
     * @id
     *
     * @GeneratedValue (strategy = "AUTO")
     * @column (type="integer")
     */
    protected $id;

    /**
     *
     * @OneToOne(targetEntity="XLite\Model\Product", inversedBy = "toolDetails")
     * @JoinColumn(name="product_id", referencedColumnName="product_id")
     */
    protected $product;


    /**
     * @column (type="text")
     */
    protected $brand;


    /**
     * @column (type="text")
     */
    protected $toolModel;


    /**
     * @column (type="text")
     */
    protected $toolCondition;

    /**
     * @column (type="text")
     */
    protected $powerSource;


    /**
     * @column (type="text")
     */
    protected $additionalDetails;



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \XLite\Model\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param \XLite\Model\Product $product
     */
    public function setProduct(\XLite\Model\Product $product = null)
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * @return mixed
     */
    public function getToolModel()
    {
        return $this->toolModel;
    }

    /**
     * @param mixed $toolModel
     */
    public function setToolModel($toolModel)
    {
        $this->toolModel = $toolModel;
    }


    /**
     * @return mixed
     */
    public function getToolCondition()
    {
        return $this->toolCondition;
    }

    /**
     * @param mixed $toolCondition
     */
    public function setToolCondition($toolCondition)
    {
        $this->toolCondition = $toolCondition;
    }

    /**
     * @return mixed
     */
    public function getPowerSource()
    {
        return $this->powerSource;
    }

    /**
     * @param mixed $powerSource
     */
    public function setPowerSource($powerSource)
    {
        $this->powerSource = $powerSource;
    }

    /**
     * @return mixed
     */
    public function getAdditionalDetails()
    {
        return $this->additionalDetails;
    }

    /**
     * @param mixed $additionalDetails
     */
    public function setAdditionalDetails($additionalDetails)
    {
        $this->additionalDetails = $additionalDetails;
    }

}

