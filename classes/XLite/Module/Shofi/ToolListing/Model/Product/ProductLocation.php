<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\Shofi\ToolListing\Model\Product;
/**
 * Product Location
 *
 * @Entity
 * @Table  (name="product_location",
 *      indexes={
 *          @Index (name="product_id", columns={"product_id"})
 *      }
 * )
 */

class ProductLocation extends \XLite\Model\AEntity {


    /**
     * Product Location unique ID
     * @var integer
     *
     * @Id
     * @GeneratedValue (strategy = "AUTO")
     * @column (type="integer", options={ "unsigned": true })
     */
    protected $id;

    /**
     * Product (association)
     *
     * @var \XLite\Model\Product
     *
     * @OneToOne (targetEntity="XLite\Model\Product", inversedBy="productLocation")
     * @JoinColumn (name="product_id", referencedColumnName="product_id")
     */
    protected $product;

    /**
     * @Column (type="text", length = 50)
     */
    protected $locationName = "";


    /**
     * @Column (type="float", length = 50)
     */
    protected $lat = 0.00;

    /**
     * @Column (type="float", length = 50)
     */
    protected $lang = 0.00;


    /**
     * Set product
     *
     * @param \XLite\Model\Product $product
     * @return ProductLocation
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
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return mixed
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param mixed $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
    }



    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLocationName()
    {
        return $this->locationName;
    }

    /**
     * @param mixed $locationName
     */
    public function setLocationName($locationName)
    {
        $this->locationName = $locationName;
    }


}

?>