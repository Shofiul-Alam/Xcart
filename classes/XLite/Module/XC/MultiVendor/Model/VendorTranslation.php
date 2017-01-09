<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\Model;

/**
 * Vendor
 *
 * @Entity
 * @Table (name="vendor_translations",
 *      indexes={
 *          @Index (name="ci", columns={"code","id"}),
 *          @Index (name="id", columns={"id"})
 *      }
 * )
 */
class VendorTranslation extends \XLite\Model\Base\Translation
{
    /**
     * Company name
     *
     * @var string
     *
     * @Column (type="string")
     */
    protected $companyName = '';

    /**
     * Location
     *
     * @var string
     *
     * @Column (type="string")
     */
    protected $location = '';

    /**
     * Description ("about vendor")
     *
     * @var string
     *
     * @Column (type="text")
     */
    protected $description = '';

    /**
     * Set companyName
     *
     * @param string $companyName
     * @return VendorTranslation
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
        return $this;
    }

    /**
     * Get companyName
     *
     * @return string 
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return VendorTranslation
     */
    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set description
     *
     * @param text $description
     * @return VendorTranslation
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
     * Get label_id
     *
     * @return integer 
     */
    public function getLabelId()
    {
        return $this->label_id;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return VendorTranslation
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }
}
