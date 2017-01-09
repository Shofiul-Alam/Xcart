<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\Shofi\ToolListing\Model\DTO\Product;

use Symfony\Component\Validator\Context\ExecutionContextInterface;
use XLite\Core\Translation;
use XLite\Model\DTO\Base\CommonCell;

class Info extends  \XLite\Model\DTO\Base\ADTO
{
    /**
     * @param Info                      $dto
     * @param ExecutionContextInterface $context
     */
    public static function validate($dto, ExecutionContextInterface $context)
    {
        if (!empty($dto->default->sku) && !static::isSKUValid($dto)) {
            static::addViolation($context, 'default.sku', Translation::lbl('SKU must be unique'));
        }

        if ($dto->marketing->meta_description_type === 'C' && '' === trim($dto->marketing->meta_description)) {
            static::addViolation($context, 'marketing.meta_description', Translation::lbl('This field is required'));
        }

        if (!$dto->marketing->clean_url->autogenerate && !$dto->marketing->clean_url->force) {
            $repo  = \XLite\Core\Database::getRepo('XLite\Model\CleanURL');
            $value = $dto->marketing->clean_url->clean_url . '.html';

            if (!$repo->isURLUnique($value, 'XLite\Model\Product', $dto->default->identity)) {
                static::addViolation($context, 'marketing.clean_url.clean_url', Translation::lbl('The Clean URL entered is already in use.'));
            }
        }
    }

    /**
     * @param Info $dto
     *
     * @return boolean
     */
    protected static function isSKUValid($dto)
    {
        $sku      = $dto->default->sku;
        $identity = $dto->default->identity;

        $entity = \XLite\Core\Database::getRepo('XLite\Model\Product')->findOneBySku($sku);

        return !$entity || (int) $entity->getProductId() === (int) $identity;
    }

    /**
     * @param mixed|\XLite\Model\Product $object
     */
    protected function init($object)
    {
        $categories = [];
        foreach ($object->getCategories() as $category) {
            $categories[] = $category->getCategoryId();
        }

        $objectImages = $object->getImages();
        $images       = [0 => [
            'delete'   => false,
            'position' => '',
            'alt'      => '',
            'temp_id'  => '',
        ]];
        foreach ($objectImages as $image) {

            $images[$image->getId()] = [
                'delete'   => false,
                'position' => '',
                'alt'      => '',
                'temp_id'  => '',
            ];

        }



        $default       = [
            'identity' => $object->getProductId(),

            'name'                 => $object->getName(),
            //'sku'                  => $object->getSku(),
            'images'               => $images,
            'category'             => $categories,
            'category_tree'        => $categories,
            'category_widget_type' => \XLite\Core\Request::getInstance()->product_modify_categroy_widget ?: 'search',
            'description'          => $object->getBriefDescription(),
            'full_description'     => $object->getDescription(),
            //'available_for_sale'   => $object->getEnabled(),
            //'arrival_date'         => $object->getArrivalDate() ?: time(),

        ];
        $this->default = new CommonCell($default);

        if($object->getToolDetails()){
            $additionalInfo = $object->getToolDetails();
        } else {
            $additionalInfo = new \XLite\Module\Shofi\ToolListing\Model\Product\ToolDetails();
        }
        xdebug_break();
        $additionalInformation       = [
            'brand'                => $additionalInfo->getBrand(),
            'model'                => $additionalInfo->getToolModel(),
            'power_source'         => $additionalInfo->getPowerSource(),
            'condition'            => $additionalInfo->getToolCondition(),
            'additional_details'   => $additionalInfo->getAdditionalDetails(),
        ];

        $this->additionalInfoSection = new CommonCell($additionalInformation);
    /*
        $memberships = [];
        foreach ($object->getMemberships() as $membership) {
            $memberships[] = $membership->getMembershipId();
        }
    */

        //$taxClass                   = $object->getTaxClass();
        /*
        $inventoryTracking          = new CommonCell([
            'inventory_tracking' => $object->getInventoryEnabled(),
            'quantity'           => $object->getAmount(),
        ]);*/

        if($object->getAprice()){
            $aprice = $object->getAprice();
        } else {
            $aprice = new \XLite\Module\Shofi\ToolListing\Model\Product\Aprice();
        }

        $pricesAndInventory         = [
            //'memberships'        => $memberships,
           // 'tax_class'          => $taxClass ? $taxClass->getId() : null,
            'price'              => $object->getPrice(),
            //'inventory_tracking' => $inventoryTracking,
            'tool_value'         => $aprice->getToolValue(),
            'daily_price'        => $aprice->getDailyPrice(),
            'weekly_price'       => $aprice->getWeeklyPrice(),
            'bond'               => $aprice->getBond(),
            'gurantee_fee'       => $aprice->getGuaranteeFee(),
        ];
        $this->prices_and_inventory = new CommonCell($pricesAndInventory);
/*
        $shippingBox    = new CommonCell([
            'separate_box' => $object->getUseSeparateBox(),
            'dimensions'   => [
                'length' => $object->getBoxLength(),
                'width'  => $object->getBoxWidth(),
                'height' => $object->getBoxHeight(),
            ],
        ]);
        $itemsInBox     = new CommonCell([
            'items_in_box' => $object->getItemsPerBox(),
        ]);
        $shipping       = [
            'weight'            => $object->getWeight(),
            'requires_shipping' => $object->getShippable(),
            'shipping_box'      => $shippingBox,
            'items_in_box'      => $itemsInBox,
        ];
        $this->shipping = new CommonCell($shipping);
*/
        $cleanURL = new CommonCell([
            'autogenerate' => !(boolean) $object->getCleanURL(),
            'clean_url'    => preg_replace('/.html$/', '', $object->getCleanURL()),
            'force'        => false,
        ]);

        $marketing       = [
            //'meta_description_type' => $object->getMetaDescType(),
            //'meta_description'      => $object->getMetaDesc(),
            //'meta_keywords'         => $object->getMetaTags(),
            //'product_page_title'    => $object->getMetaTitle(),
            'clean_url'             => $cleanURL,
        ];
        $this->marketing = new CommonCell($marketing);
    }

    /**
     * @param \XLite\Model\Product $object
     * @param array|null           $rawData
     *
     * @return mixed
     */
    public function populateTo($object, $rawData = null)
    {
        $default = $this->default;

        $object->setName((string) $default->name);

        //$sku = trim($default->sku);
        //$object->setSku((string) $sku);
        xdebug_break();
        $object->processFiles('images', $default->images);
        xdebug_break();
        $categories = \XLite\Core\Database::getRepo('XLite\Model\Category')->findByIds($default->category);
        $object->replaceCategoryProductsLinksByCategories($categories);

        $object->setBriefDescription((string) $rawData['default']['description']);
        $object->setDescription((string) $rawData['default']['full_description']);

        //$object->setEnabled((boolean) $default->available_for_sale);
        //$object->setArrivalDate((int) $default->arrival_date);

        xdebug_break();

        if($object->getToolDetails()){
            $additionalInfo = $object->getToolDetails();
        } else {
            $additionalInfo = new \XLite\Module\Shofi\ToolListing\Model\Product\ToolDetails();
        }
        xdebug_break();
        $additionalInformation = $this->additionalInfoSection;
        xdebug_break();

        $additionalInfo->setBrand((string) $additionalInformation->brand);
        $additionalInfo->setToolModel((string) $additionalInformation->model);
        xdebug_break();
        $additionalInfo->setPowerSource((string) $additionalInformation->power_source);
        $additionalInfo->setToolCondition((string) $additionalInformation->condition);
        $additionalInfo->setAdditionalDetails((string) $additionalInformation->additional_details);
        xdebug_break();
        $additionalInfo->setProduct($object);
            xdebug_break();
        $object->setToolDetails($additionalInfo);

        //Set Product Location Object
        xdebug_break();
        if($object->getProductLocation()) {
            $productLocation = $object->getProductLocation();
        } else {
            $productLocation = new \XLite\Module\Shofi\ToolListing\Model\Product\ProductLocation();
        }

        $productAddress = $this->getGeoAddress();
        $geoCode = $this->getGeocode($productAddress);
        $productLocation->setLat($geoCode['latitude']);
        $productLocation->setLang((float) $geoCode['longitude']);
        $productLocation->setLocationName($default->name);
        $productLocation->setProduct($object);

        $object->setProductLocation($productLocation);

xdebug_break();
        $priceAndInventory = $this->prices_and_inventory;
        //$memberships       = \XLite\Core\Database::getRepo('XLite\Model\Membership')->findByIds($priceAndInventory->memberships);
        //$object->replaceMembershipsByMemberships($memberships);

        //$taxClass = \XLite\Core\Database::getRepo('XLite\Model\TaxClass')->find($priceAndInventory->tax_class);
        //$object->setTaxClass($taxClass);

        $object->setPrice((float) $priceAndInventory->price);
        if($object->getAprice()){
            $aprice = $object->getAprice();
        } else {
            $aprice = new \XLite\Module\Shofi\ToolListing\Model\Product\Aprice();
        }
        $aprice->setBond((float) $priceAndInventory->bond);
        $aprice->setToolValue((float) $priceAndInventory->tool_value);
        $aprice->setDailyPrice((float) $priceAndInventory->daily_price);
        $aprice->setWeeklyPrice((float) $priceAndInventory->daily_price);
        $aprice->setProduct($object);

        $object->setAprice($aprice);


       // $object->setInventoryEnabled((boolean) $priceAndInventory->inventory_tracking->inventory_tracking);
        //$object->setAmount((int) $priceAndInventory->inventory_tracking->quantity);

        /*
        $shipping = $this->shipping;
        $object->setWeight((float) $shipping->weight);
        $object->setShippable((boolean) $shipping->requires_shipping);

        $shippingBox = $shipping->shipping_box;
        $object->setUseSeparateBox((boolean) $shippingBox->separate_box);

        $object->setBoxLength($shippingBox->dimensions['length']);
        $object->setBoxWidth($shippingBox->dimensions['width']);
        $object->setBoxHeight($shippingBox->dimensions['height']);

        $object->setItemsPerBox($shipping->items_in_box->items_in_box);

        xdebug_break();
*/
        $marketing = $this->marketing;
        //$object->setMetaDescType($marketing->meta_description_type);
        //$object->setMetaDesc((string) $marketing->meta_description);
        //$object->setMetaTags((string) $marketing->meta_keywords);
        //$object->setMetaTitle((string) $marketing->product_page_title);

        if ($marketing->clean_url->autogenerate
            || empty($marketing->clean_url->clean_url)
        ) {
            $object->setCleanURL(\XLite\Core\Database::getRepo('XLite\Model\CleanURL')->generateCleanURL($object));

        } else {
            $value = $marketing->clean_url->clean_url . '.html';
            if ($marketing->clean_url->force) {
                $repo           = \XLite\Core\Database::getRepo('XLite\Model\CleanURL');
                $conflictEntity = $repo->getConflict(
                    $value,
                    $object,
                    $object->getProductId()
                );

                if ($conflictEntity && $value !== $conflictEntity->getCleanURL()) {
                    /** @var \Doctrine\Common\Collections\Collection $cleanURLs */
                    $cleanURLs = $conflictEntity->getCleanURLs();
                    /** @var \XLite\Model\CleanURL $cleanURL */
                    foreach ($cleanURLs as $cleanURL) {
                        if ($value === $cleanURL->getCleanURL()) {
                            $cleanURLs->removeElement($cleanURL);
                            \XLite\Core\Database::getEM()->remove($cleanURL);

                            break;
                        }
                    }
                }

                $object->setCleanURL((string) $value, !$conflictEntity || !($conflictEntity instanceof \XLite\Model\TargetCleanUrl));

            } else {
                $object->setCleanURL((string) $value);
            }

        }
    }

    /**
     * @param \XLite\Model\Product $object
     * @param array|null           $rawData
     *
     * @return mixed
     */
    public function afterUpdate($object, $rawData = null)
    {

        $object->updateQuickData();
    }

    /**
     * @param \XLite\Model\Product $object
     * @param array|null           $rawData
     *
     * @return mixed
     */
    public function afterCreate($object, $rawData = null)
    {
        \XLite\Core\Database::getRepo('XLite\Model\Attribute')->generateAttributeValues($object);

        if (!$object->getSku()) {
            $sku = \XLite\Core\Database::getRepo('XLite\Model\Product')->generateSKU($object);
            $object->setSku((string) $sku);
        }
    }

    /**
     * @param text  $string
     *
     * @return array
     */

    public function getGeocode($string){

        xdebug_break();

        $string = str_replace (" ", "+", urlencode($string));
        $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$string."&sensor=false";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $details_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch), true);

        xdebug_break();
        // If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
        if ($response['status'] != 'OK') {
            return null;
        }


        $geometry = $response['results'][0]['geometry'];

        xdebug_break();
        $latitude  = $geometry['location']['lat'];
        $longitude = $geometry['location']['lng'];
        xdebug_break();
        $array = array(
            'latitude' => $latitude,
            'longitude' => $longitude,
            'location_type' => $geometry['location_type'],
        );

        xdebug_break();
        return $array;

    }

    /**
     * @param
     */

    public function getGeoAddress() {

        $country = "";
        $state = "";
        $custom_state = "";
        $zipcode = "";
        $street = "";
        $city = "";
        $profile = \XLite\Core\Auth::getInstance()->getProfile();
        $firstAddress = $profile->getFirstAddress();
        xdebug_break();
        if($firstAddress) {
            $addressFields = $firstAddress->getAddressFields();
        }
        xdebug_break();

        if($addressFields) {
            foreach ($addressFields as $field) {
                    $fieldServiceName = $field->getAddressField()->getServiceName();

                switch ($fieldServiceName) {
                    case 'country_code':
                       $country = $field->getValue();
                        break;
                    case 'state_id':
                        $state = \XLite\Core\Database::getRepo('\XLite\Model\State')->find($field->getValue())->getState();
                        break;
                    case 'custom_state':
                        $custom_state = $field->getValue();
                        break;
                    case 'zipcode':
                        $zipcode = $field->getValue();
                        break;
                    case 'city':
                        $city = $field->getValue();
                        break;
                    case 'street':
                        $street = $field->getValue();
                        break;
                    default:
                        break;
                }

            }
        }
        if($custom_state) {
            $state = $custom_state;
        }
        xdebug_break();
        $geoAddress = $street . ' ' . $city . ' ' . $state . ' ' . $zipcode . ' ' . $country;

        return $geoAddress;

    }

}
