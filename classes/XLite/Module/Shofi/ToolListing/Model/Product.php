<?php


namespace XLite\Module\Shofi\ToolListing\Model;


abstract class Product extends \XLite\Model\Product implements \XLite\Base\IDecorator
{
    /**
     * This is Product Location Object for Google Geolocation
     *
     *
     * @OneToOne (targetEntity="XLite\Module\Shofi\ToolListing\Model\Product\ProductLocation", mappedBy="product", cascade = {"all"})
     */
    protected $productLocation;


    /**
     * This is Product advance price
     *
     *
     * @OneToOne (targetEntity="XLite\Module\Shofi\ToolListing\Model\Product\Aprice", mappedBy="product", cascade = {"all"})
     */
    protected $aprice;

    /**
     * @OneToOne(targetEntity="XLite\Module\Shofi\ToolListing\Model\Product\ToolDetails", mappedBy="product", cascade = {"all"})
     */
    protected $toolDetails;




    /**
     * Set productLocation
     *
     * @param \XLite\Module\Shofi\ToolListing\Model\Product\ProductLocation $productLocation
     */

    public function setProductLocation(\XLite\Module\Shofi\ToolListing\Model\Product\ProductLocation $productLocation = null) {
        $this->productLocation = $productLocation;
    }


    /**
     * Get productLocation
     *
     * @return \XLite\Module\Shofi\ToolListing\Model\Product\ProductLocation
     */

    public function getProductLocation() {

      return $this->productLocation;
    }



    /**
     * Set Aprice
     *
     * @param \XLite\Module\Shofi\ToolListing\Model\Product\Aprice $aprice
     */

    public function setAprice(\XLite\Module\Shofi\ToolListing\Model\Product\Aprice $aprice = null) {
        $this->aprice = $aprice;
    }


    /**
     * Get advace price
     *
     * @return \XLite\Module\Shofi\ToolListing\Model\Product\Aprice
     */

    public function getAprice() {
        return $this->aprice;
    }

    /**
     * @return \XLite\Module\Shofi\ToolListing\Model\Product\ToolDetails
     */
    public function getToolDetails()
    {
        return $this->toolDetails;
    }

    /**
     * @param \XLite\Module\Shofi\ToolListing\Model\Product\ToolDetails $toolDetails
     */
    public function setToolDetails(\XLite\Module\Shofi\ToolListing\Model\Product\ToolDetails $toolDetails=null)
    {
        $this->toolDetails = $toolDetails;
    }



}
