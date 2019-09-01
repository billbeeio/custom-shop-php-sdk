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

use DateTime;
use JMS\Serializer\Annotation as Serializer;

class Order
{
    /**
     * @var string
     * @Serializer\SerializedName("order_id")
     * @Serializer\Type("string")
     */
    public $orderId;

    /**
     * @var string
     * @Serializer\SerializedName("order_number")
     * @Serializer\Type("string")
     */
    public $orderNumber;

    /**
     * @var string
     * @Serializer\SerializedName("currency_code")
     * @Serializer\Type("string")
     */
    public $countryCode;

    /**
     * @var string
     * @Serializer\SerializedName("nick_name")
     * @Serializer\Type("string")
     */
    public $nickName;

    /**
     * @var float
     * @Serializer\SerializedName("ship_cost")
     * @Serializer\Type("float")
     */
    public $shipCost;

    /**
     * @var Address
     * @Serializer\SerializedName("invoice_address")
     * @Serializer\Type("Billbee\CustomShopApi\Model\Address")
     */
    public $invoiceAddress;

    /**
     * @var Address
     * @Serializer\SerializedName("delivery_address")
     * @Serializer\Type("Billbee\CustomShopApi\Model\Address")
     */
    public $deliveryAddress;

    /**
     * @var DateTime
     * @Serializer\SerializedName("order_date")
     * @Serializer\Type("DateTime")
     */
    public $orderDate;

    /**
     * @var string
     * @Serializer\SerializedName("email")
     * @Serializer\Type("string")
     */
    public $email;

    /**
     * @var string
     * @Serializer\SerializedName("phone1")
     * @Serializer\Type("string")
     */
    public $phone1;

    /**
     * @var DateTime
     * @Serializer\SerializedName("pay_date")
     * @Serializer\Type("DateTime")
     */
    public $payDate;

    /**
     * @var DateTime
     * @Serializer\SerializedName("ship_date")
     * @Serializer\Type("DateTime")
     */
    public $shipDate;

    /**
     * @var int
     * @Serializer\SerializedName("payment_method")
     * @Serializer\Type("int")
     */
    public $paymentMethod;

    /**
     * @var int
     * @Serializer\SerializedName("order_status_id")
     * @Serializer\Type("int")
     */
    public $statusId;

    /**
     * @var OrderProduct[]
     * @Serializer\SerializedName("order_products")
     * @Serializer\Type("array<Billbee\CustomShopApi\Model\OrderProduct>")
     */
    public $items;

    /**
     * @var OrderComment[]
     * @Serializer\SerializedName("order_history")
     * @Serializer\Type("array<Billbee\CustomShopApi\Model\OrderComment>")
     */
    public $comments;

    /**
     * @var string
     * @Serializer\SerializedName("seller_comment")
     * @Serializer\Type("string")
     */
    public $sellerComment;

    /**
     * @var string
     * @Serializer\SerializedName("shippingprofile_id")
     * @Serializer\Type("string")
     */
    public $shippingProfileId;

    /**
     * @var string
     * @Serializer\SerializedName("vat_id")
     * @Serializer\Type("string")
     */
    public $vatId;

    /**
     * @var string
     * @Serializer\SerializedName("payment_transaction_id")
     * @Serializer\Type("string")
     */
    public $paymentTransactionId;

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     * @return Order
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @param mixed $orderNumber
     * @return Order
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param mixed $countryCode
     * @return Order
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * @param mixed $nickName
     * @return Order
     */
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShipCost()
    {
        return $this->shipCost;
    }

    /**
     * @param mixed $shipCost
     * @return Order
     */
    public function setShipCost($shipCost)
    {
        $this->shipCost = $shipCost;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoiceAddress()
    {
        return $this->invoiceAddress;
    }

    /**
     * @param mixed $invoiceAddress
     * @return Order
     */
    public function setInvoiceAddress($invoiceAddress)
    {
        $this->invoiceAddress = $invoiceAddress;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }

    /**
     * @param mixed $deliveryAddress
     * @return Order
     */
    public function setDeliveryAddress($deliveryAddress)
    {
        $this->deliveryAddress = $deliveryAddress;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * @param mixed $orderDate
     * @return Order
     */
    public function setOrderDate($orderDate)
    {
        $this->orderDate = $orderDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Order
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone1()
    {
        return $this->phone1;
    }

    /**
     * @param mixed $phone1
     * @return Order
     */
    public function setPhone1($phone1)
    {
        $this->phone1 = $phone1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPayDate()
    {
        return $this->payDate;
    }

    /**
     * @param mixed $payDate
     * @return Order
     */
    public function setPayDate($payDate)
    {
        $this->payDate = $payDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShipDate()
    {
        return $this->shipDate;
    }

    /**
     * @param mixed $shipDate
     * @return Order
     */
    public function setShipDate($shipDate)
    {
        $this->shipDate = $shipDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param mixed $paymentMethod
     * @return Order
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusId()
    {
        return $this->statusId;
    }

    /**
     * @param mixed $statusId
     * @return Order
     */
    public function setStatusId($statusId)
    {
        $this->statusId = $statusId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $items
     * @return Order
     */
    public function setItems($items)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     * @return Order
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSellerComment()
    {
        return $this->sellerComment;
    }

    /**
     * @param mixed $sellerComment
     * @return Order
     */
    public function setSellerComment($sellerComment)
    {
        $this->sellerComment = $sellerComment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShippingProfileId()
    {
        return $this->shippingProfileId;
    }

    /**
     * @param mixed $shippingProfileId
     * @return Order
     */
    public function setShippingProfileId($shippingProfileId)
    {
        $this->shippingProfileId = $shippingProfileId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVatId()
    {
        return $this->vatId;
    }

    /**
     * @param mixed $vatId
     * @return Order
     */
    public function setVatId($vatId)
    {
        $this->vatId = $vatId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentTransactionId()
    {
        return $this->paymentTransactionId;
    }

    /**
     * @param mixed $paymentTransactionId
     * @return Order
     */
    public function setPaymentTransactionId($paymentTransactionId)
    {
        $this->paymentTransactionId = $paymentTransactionId;
        return $this;
    }
}
