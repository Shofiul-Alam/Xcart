<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XC\MultiVendor\View\Model;

use Xlite\Core;
use XLite\Module\XC\MultiVendor;

/**
 * Settings dialog model widget
 */
class Settings extends \XLite\View\Model\Settings implements \XLite\Base\IDecorator
{
    /**
     * Defaults
     *
     * @var array
     */
    protected $defaults = array();

    /**
     * Default values
     *
     * @var array
     */
    protected $defaultValues = array();

    /**
     * Retrieve property from the model object
     *
     * @param string $name Field/property name
     *
     * @return mixed
     */
    protected function getModelObjectValue($name)
    {
        $vendorOption = $this->getCurrentVendorOptionByName($name);
        $value = null;

        if ('enable_vendor_rating' === $name
            && !$this->vendorRatingOptionAllowed()
        ) {
            $value = static::t('Reviews module required');

        } else {
            $value = $vendorOption
                ? $vendorOption->getValue()
                : ($this->hasDefaultValue($name) ? $this->getDefaultValue($name) : parent::getModelObjectValue($name));
        }

        return $value;
    }

    /**
     * Returns vendor option by name
     *
     * @param string $name Field/property name
     *
     * @return \XLite\Model\Config
     */
    protected function getCurrentVendorOptionByName($name)
    {
        $result = null;
        $vendor = Core\Auth::getInstance()->getVendor();

        if ($vendor) {
            $option = $this->getOptionByName($name);
            if ($option) {
                /** @var \Xlite\Model\Repo\Config $repo */
                $repo = Core\Database::getRepo('XLite\Model\Config');
                $result = $repo->findOneBy(
                    array(
                        'name' => $option->getName(),
                        'category' => $option->getCategory(),
                        'vendor' => $vendor,
                    )
                );
            }
        }

        return $result;
    }

    /**
     * Returns option by name
     *
     * @param string $name Field/property name
     *
     * @return \XLite\Model\Config
     */
    protected function getOptionByName($name)
    {
        $result = null;

        foreach ($this->getOptions() as $option) {
            if ($option->getName() === $name) {
                $result = $option;

                break;
            }
        }

        return $result;
    }

    /**
     * Check if option value is changed
     *
     * @param \XLite\Model\Config $option Config option
     * @param string              $value  New value
     *
     * @return string
     */
    protected function isChanged($option, $value)
    {
        $result = parent::isChanged($option, $value);

        if (!$result
            && null !== $value
            && Core\Auth::getInstance()->isVendor()
        ) {
            $vendorsOption = $this->getCurrentVendorOptionByName($option->getName());
            $result = null === $vendorsOption || parent::isChanged($vendorsOption, $value);
        }

        return $result;
    }

    /**
     * Return default settings
     *
     * @param string $category Category
     *
     * @return \XLite\Core\ConfigCell
     */
    protected function getDefaults($category)
    {
        if (!isset($this->defaults[$category])) {
            $this->defaults[$category] = MultiVendor\Main::getDefaultConfiguration(explode('\\', $category), true);
        }

        return $this->defaults[$category];
    }

    /**
     * Returns default value
     *
     * @param string $name Name
     *
     * @return mixed
     */
    protected function getDefaultValue($name)
    {
        if (!isset($this->defaultValues[$name])) {
            $option = $this->getOptionByName($name);
            $defaults = $this->getDefaults($option->getCategory());

            foreach ($defaults as $option) {
                if ($option->getName() === $name) {
                    $this->defaultValues[$name] = $option->getValue();

                    break;
                }
            }
        }

        return isset($this->defaultValues[$name]) ? $this->defaultValues[$name] : null;
    }

    /**
     * Check default value
     *
     * @param  string $name Name
     *
     * @return boolean
     */
    protected function hasDefaultValue($name)
    {
        return Core\Auth::getInstance()->isVendor()
            && null !== $this->getDefaultValue($name);
    }

    /**
     * Check if vendor rating option allowed
     *
     * @return boolean
     */
    protected function vendorRatingOptionAllowed()
    {
        return \XLite\Core\Database::getRepo('XLite\Model\Module')->isModuleEnabled('XC\Reviews');
    }

    /**
     * Get form field by option
     *
     * @param \XLite\Model\Config $option Option
     *
     * @return array
     */
    protected function getFormFieldByOption(\XLite\Model\Config $option)
    {
        $result = parent::getFormFieldByOption($option);

        if ('enable_vendor_rating' === $option->getName()
            && !$this->vendorRatingOptionAllowed()
        ) {
            $result = array(
                static::SCHEMA_CLASS    => '\XLite\View\FormField\Label',
                static::SCHEMA_LABEL    => $option->getOptionName(),
                static::SCHEMA_REQUIRED => false,
            );
        }

        return $result;
    }
}
