<?php
/**
 * This file is part of the Billbee Custom Shop API package.
 *
 * Copyright 2019-2022 by Billbee GmbH
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
     * @Serializer\SerializedName("material")
     * @Serializer\Type("string")
     */
    public ?string $material = null;

    /**
     * @Serializer\SerializedName("shortdescription")
     * @Serializer\Type("string")
     */
    public ?string $shortDescription = null;

    /**
     * @Serializer\SerializedName("basic_attributes")
     * @Serializer\Type("string")
     */
    public ?string $basicAttributes = null;

    /**
     * @Serializer\SerializedName("description")
     * @Serializer\Type("string")
     */
    public ?string $description = null;

    /**
     * @Serializer\SerializedName("id")
     * @Serializer\Type("string")
     */
    public ?string $id = null;

    /**
     * @var ?ProductImage[]
     * @Serializer\SerializedName("images")
     * @Serializer\Type("array<Billbee\CustomShopApi\Model\ProductImage>")
     */
    public ?array $images = null;

    /**
     * @Serializer\SerializedName("title")
     * @Serializer\Type("string")
     */
    public ?string $title = null;

    /**
     * @Serializer\SerializedName("price")
     * @Serializer\Type("float")
     */
    public ?float $price = null;

    /**
     * @Serializer\SerializedName("quantity")
     * @Serializer\Type("float")
     */
    public ?float $quantity = null;

    /**
     * @Serializer\SerializedName("sku")
     * @Serializer\Type("string")
     */
    public ?string $sku = null;

    /**
     * @Serializer\SerializedName("ean")
     * @Serializer\Type("string")
     */
    public ?string $ean = null;

    /**
     * @Serializer\SerializedName("manufacturer")
     * @Serializer\Type("string")
     */
    public ?string $manufacturer = null;

    /**
     * @var bool
     * @Serializer\SerializedName("isdigital")
     * @Serializer\Type("bool")
     */
    public bool $isDigital = false;

    /**
     * @Serializer\SerializedName("weight")
     * @Serializer\Type("float")
     */
    public ?float $weightInKg = null;

    /**
     * @Serializer\SerializedName("vat_rate")
     * @Serializer\Type("float")
     */
    public ?float $vatRate = null;

    /**
     * @Serializer\SerializedName("lengthcm")
     * @Serializer\Type("float")
     */
    public ?float $lengthInCm = null;

    /**
     * @Serializer\SerializedName("widthcm")
     * @Serializer\Type("float")
     */
    public ?float $widthInCm = null;

    /**
     * @Serializer\SerializedName("heightcm")
     * @Serializer\Type("float")
     */
    public ?float $heightInCm = null;

    /**
     * @var array<string, string>
     * @Serializer\SerializedName("customfields")
     * @Serializer\Type("array<string, string>")
     */
    public ?array $customFields = null;

    public function getMaterial(): ?string
    {
        return $this->material;
    }

    public function setMaterial(?string $material): Product
    {
        $this->material = $material;
        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): Product
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    public function getBasicAttributes(): ?string
    {
        return $this->basicAttributes;
    }

    public function setBasicAttributes(?string $basicAttributes): Product
    {
        $this->basicAttributes = $basicAttributes;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): Product
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ?ProductImage[]
     */
    public function getImages(): ?array
    {
        return $this->images;
    }

    /**
     * @param ?ProductImage[] $images
     */
    public function setImages(?array $images): self
    {
        $this->images = $images;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): Product
    {
        $this->title = $title;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): Product
    {
        $this->price = $price;
        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(?float $quantity): Product
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(?string $sku): Product
    {
        $this->sku = $sku;
        return $this;
    }

    public function getEan(): ?string
    {
        return $this->ean;
    }

    public function setEan(?string $ean): Product
    {
        $this->ean = $ean;
        return $this;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?string $manufacturer): Product
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    public function isDigital(): bool
    {
        return $this->isDigital;
    }

    public function setIsDigital(bool $isDigital): Product
    {
        $this->isDigital = $isDigital;
        return $this;
    }

    public function getWeightInKg(): ?float
    {
        return $this->weightInKg;
    }

    public function setWeightInKg(?float $weightInKg): Product
    {
        $this->weightInKg = $weightInKg;
        return $this;
    }

    public function getVatRate(): ?float
    {
        return $this->vatRate;
    }

    public function setVatRate(?float $vatRate): Product
    {
        $this->vatRate = $vatRate;
        return $this;
    }

    public function getLengthInCm(): ?float
    {
        return $this->lengthInCm;
    }

    public function setLengthInCm(?float $lengthInCm): Product
    {
        $this->lengthInCm = $lengthInCm;
        return $this;
    }

    public function getWidthInCm(): ?float
    {
        return $this->widthInCm;
    }

    public function setWidthInCm(?float $widthInCm): Product
    {
        $this->widthInCm = $widthInCm;
        return $this;
    }

    public function getHeightInCm(): ?float
    {
        return $this->heightInCm;
    }

    public function setHeightInCm(?float $heightInCm): Product
    {
        $this->heightInCm = $heightInCm;
        return $this;
    }

    /**
     * @return array<string, string>
     */
    public function getCustomFields(): ?array
    {
        return $this->customFields;
    }

    /**
     * @param ?array<string, string> $customFields
     */
    public function setCustomFields(?array $customFields): Product
    {
        $this->customFields = $customFields;
        return $this;
    }
}
