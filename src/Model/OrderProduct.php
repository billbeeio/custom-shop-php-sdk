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

class OrderProduct
{
    /**
     * @Serializer\SerializedName("discount_percent")
     * @Serializer\Type("float")
     */
    public $discountPercent;

    /**
     * @Serializer\SerializedName("quantity")
     * @Serializer\Type("float")
     */
    public $quantity;

    /**
     * @Serializer\SerializedName("unit_price")
     * @Serializer\Type("float")
     */
    public $unitPrice;

    /**
     * @Serializer\SerializedName("product_id")
     * @Serializer\Type("string")
     */
    public $productId;

    /**
     * @Serializer\SerializedName("name")
     * @Serializer\Type("string")
     */
    public $name;

    /**
     * @Serializer\SerializedName("sku")
     * @Serializer\Type("string")
     */
    public $sku;

    /**
     * @Serializer\SerializedName("tax_rate")
     * @Serializer\Type("float")
     */
    public $taxRate;

    /**
     * @Serializer\SerializedName("options")
     * @Serializer\Type("array<Billbee\CustomShopApi\Model\OrderProductOption>")
     */
    public $options;

    /**
     * @return mixed
     */
    public function getDiscountPercent()
    {
        return $this->discountPercent;
    }

    /**
     * @param mixed $discountPercent
     * @return OrderProduct
     */
    public function setDiscountPercent($discountPercent)
    {
        $this->discountPercent = $discountPercent;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     * @return OrderProduct
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @param mixed $unitPrice
     * @return OrderProduct
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param mixed $productId
     * @return OrderProduct
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return OrderProduct
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param mixed $sku
     * @return OrderProduct
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxRate()
    {
        return $this->taxRate;
    }

    /**
     * @param mixed $taxRate
     * @return OrderProduct
     */
    public function setTaxRate($taxRate)
    {
        $this->taxRate = $taxRate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $options
     * @return OrderProduct
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }
}
