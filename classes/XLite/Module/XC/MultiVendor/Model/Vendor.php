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
 * @Table (name="vendor")
 */
class Vendor extends \XLite\Model\Base\I18n
{
    /**
     * Unique ID
     *
     * @var integer
     *
     * @Id
     * @GeneratedValue (strategy="AUTO")
     * @Column         (type="integer", options={ "unsigned": true })
     */
    protected $id;

    /**
     * Profile
     *
     * @var \XLite\Model\Profile
     *
     * @OneToOne   (targetEntity="XLite\Model\Profile", inversedBy="vendor")
     * @JoinColumn (name="profile_id", referencedColumnName="profile_id", onDelete="CASCADE")
     */
    protected $profile;

    /**
     * Get name
     *
     * @return string
     */
    public function getName($useDefault = true)
    {
        $result = $this->getProfile() ? $this->getProfile()->getName(false) : '';

        return $result ?: ($useDefault ? static::t('na_vendor') : '');
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
     * Set profile
     *
     * @param \XLite\Model\Profile $profile
     * @return Vendor
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
}
