<?php
/**
 * This file is part of the Billbee Custom Shop API package.
 *
 * Copyright 2019 by Billbee GmbH
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 *
 * Created by Julian Finkler <julian@mintware.de>
 */

namespace Billbee\CustomShopApi\Model;

use JMS\Serializer\Annotation as Serializer;

class Product
{
    /**
     * @var string
     * @Serializer\SerializedName("material")
     * @Serializer\Type("string")
     */
    public $material;

    /**
     * @var string
     * @Serializer\SerializedName("shortdescription")
     * @Serializer\Type("string")
     */
    public $shortDescription;

    /**
     * @var string
     * @Serializer\SerializedName("basic_attributes")
     * @Serializer\Type("string")
     */
    public $basicAttributes;

    /**
     * @var string
     * @Serializer\SerializedName("description")
     * @Serializer\Type("string")
     */
    public $description;

    /**
     * @var string
     * @Serializer\SerializedName("id")
     * @Serializer\Type("string")
     */
    public $id;

    /**
     * @var ProductImage[]
     * @Serializer\SerializedName("images")
     * @Serializer\Type("array<Billbee\CustomShopApi\Model\ProductImage>")
     */
    public $images;

    /**
     * @var string
     * @Serializer\SerializedName("title")
     * @Serializer\Type("string")
     */
    public $title;

    /**
     * @var float
     * @Serializer\SerializedName("price")
     * @Serializer\Type("float")
     */
    public $price;

    /**
     * @var float
     * @Serializer\SerializedName("quantity")
     * @Serializer\Type("float")
     */
    public $quantity;

    /**
     * @var string
     * @Serializer\SerializedName("sku")
     * @Serializer\Type("string")
     */
    public $sku;

    /**
     * @var string
     * @Serializer\SerializedName("ean")
     * @Serializer\Type("string")
     */
    public $ean;

    /**
     * @var string
     * @Serializer\SerializedName("manufacturer")
     * @Serializer\Type("string")
     */
    public $manufacturer;

    /**
     * @var bool
     * @Serializer\SerializedName("isdigital")
     * @Serializer\Type("bool")
     */
    public $isDigital = false;

    /**
     * @var float
     * @Serializer\SerializedName("weight")
     * @Serializer\Type("float")
     */
    public $weightInKg;

    /**
     * @var float
     * @Serializer\SerializedName("vat_rate")
     * @Serializer\Type("float")
     */
    public $vatRate;

    /**
     * @var float
     * @Serializer\SerializedName("lengthcm")
     * @Serializer\Type("float")
     */
    public $lengthInCm;

    /**
     * @var float
     * @Serializer\SerializedName("widthcm")
     * @Serializer\Type("float")
     */
    public $widthInCm;

    /**
     * @var float
     * @Serializer\SerializedName("heightcm")
     * @Serializer\Type("float")
     */
    public $heightInCm;

    /**
     * @var array
     * @Serializer\SerializedName("customfields")
     * @Serializer\Type("array<string, string>")
     */
    public $customFields;

    /**
     * @return string
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * @param string $material
     * @return Product
     */
    public function setMaterial($material)
    {
        $this->material = $material;
        return $this;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     * @return Product
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getBasicAttributes()
    {
        return $this->basicAttributes;
    }

    /**
     * @param string $basicAttributes
     * @return Product
     */
    public function setBasicAttributes($basicAttributes)
    {
        $this->basicAttributes = $basicAttributes;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Product
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ProductImage[]
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param ProductImage[] $images
     * @return Product
     */
    public function setImages($images)
    {
        $this->images = $images;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = (float)$price;
        return $this;
    }

    /**
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param float $quantity
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (float)$quantity;
        return $this;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     * @return Product
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
        return $this;
    }

    /**
     * @return string
     */
    public function getEan()
    {
        return $this->ean;
    }

    /**
     * @param string $ean
     * @return Product
     */
    public function setEan($ean)
    {
        $this->ean = $ean;
        return $this;
    }

    /**
     * @return string
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * @param string $manufacturer
     * @return Product
     */
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDigital()
    {
        return $this->isDigital;
    }

    /**
     * @param bool $isDigital
     * @return Product
     */
    public function setIsDigital($isDigital)
    {
        $this->isDigital = $isDigital;
        return $this;
    }

    /**
     * @return float
     */
    public function getWeightInKg()
    {
        return $this->weightInKg;
    }

    /**
     * @param float $weightInKg
     * @return Product
     */
    public function setWeightInKg($weightInKg)
    {
        $this->weightInKg = (float)$weightInKg;
        return $this;
    }

    /**
     * @return float
     */
    public function getVatRate()
    {
        return $this->vatRate;
    }

    /**
     * @param float $vatRate
     * @return Product
     */
    public function setVatRate($vatRate)
    {
        $this->vatRate = (float)$vatRate;
        return $this;
    }

    /**
     * @return float
     */
    public function getLengthInCm()
    {
        return $this->lengthInCm;
    }

    /**
     * @param float $lengthInCm
     * @return Product
     */
    public function setLengthInCm($lengthInCm)
    {
        $this->lengthInCm = (float)$lengthInCm;
        return $this;
    }

    /**
     * @return float
     */
    public function getWidthInCm()
    {
        return $this->widthInCm;
    }

    /**
     * @param float $widthInCm
     * @return Product
     */
    public function setWidthInCm($widthInCm)
    {
        $this->widthInCm = (float)$widthInCm;
        return $this;
    }

    /**
     * @return float
     */
    public function getHeightInCm()
    {
        return $this->heightInCm;
    }

    /**
     * @param float $heightInCm
     * @return Product
     */
    public function setHeightInCm($heightInCm)
    {
        $this->heightInCm = (float)$heightInCm;
        return $this;
    }

    /**
     * @return array
     */
    public function getCustomFields()
    {
        return $this->customFields;
    }

    /**
     * @param array $customFields
     * @return Product
     */
    public function setCustomFields($customFields)
    {
        $this->customFields = $customFields;
        return $this;
    }
}
