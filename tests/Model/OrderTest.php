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

namespace Billbee\Tests\CustomShopApi\Model;

use Billbee\CustomShopApi\Model\Address;
use Billbee\CustomShopApi\Model\Order;
use DateTime;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testGettersSetters(): void
    {
        $order = new Order();
        $this->assertNull($order->getOrderId());
        $this->assertNull($order->getOrderNumber());
        $this->assertNull($order->getCurrencyCode());
        $this->assertNull($order->getDeliverySourceCountryCode());
        $this->assertNull($order->getNickName());
        $this->assertNull($order->getShipCost());
        $this->assertNull($order->getInvoiceAddress());
        $this->assertNull($order->getDeliveryAddress());
        $this->assertNull($order->getOrderDate());
        $this->assertNull($order->getEmail());
        $this->assertNull($order->getPhone1());
        $this->assertNull($order->getPayDate());
        $this->assertNull($order->getShipDate());
        $this->assertNull($order->getPaymentMethod());
        $this->assertNull($order->getStatusId());
        $this->assertNull($order->getItems());
        $this->assertNull($order->getComments());
        $this->assertNull($order->getSellerComment());
        $this->assertNull($order->getShippingProfileId());
        $this->assertNull($order->getVatId());
        $this->assertNull($order->getPaymentTransactionId());

        $invoiceAddress = new Address();
        $deliveryAddress = new Address();
        $orderDate = new DateTime();
        $payDate = new DateTime();
        $shipDate = new DateTime();

        $order->setOrderId('1234')
            ->setOrderNumber('5678')
            ->setCurrencyCode('EUR')
            ->setDeliverySourceCountryCode('DE')
            ->setNickName('foobar')
            ->setShipCost(3.99)
            ->setInvoiceAddress($invoiceAddress)
            ->setDeliveryAddress($deliveryAddress)
            ->setOrderDate($orderDate)
            ->setEmail('hello@world.tld')
            ->setPhone1('PHONE 12345')
            ->setPayDate($payDate)
            ->setShipDate($shipDate)
            ->setPaymentMethod(2)
            ->setStatusId(1)
            ->setItems([])
            ->setComments([])
            ->setSellerComment('Seller Comment')
            ->setShippingProfileId('FLATRATE')
            ->setVatId('DE1234')
            ->setPaymentTransactionId('PAY-1234');

        $this->assertEquals('1234', $order->getOrderId());
        $this->assertEquals('5678', $order->getOrderNumber());
        $this->assertEquals('EUR', $order->getCurrencyCode());
        $this->assertEquals('DE', $order->getDeliverySourceCountryCode());
        $this->assertEquals('foobar', $order->getNickName());
        $this->assertEquals(3.99, $order->getShipCost());
        $this->assertSame($invoiceAddress, $order->getInvoiceAddress());
        $this->assertSame($deliveryAddress, $order->getDeliveryAddress());
        $this->assertSame($orderDate, $order->getOrderDate());
        $this->assertEquals('hello@world.tld', $order->getEmail());
        $this->assertEquals('PHONE 12345', $order->getPhone1());
        $this->assertSame($payDate, $order->getPayDate());
        $this->assertSame($shipDate, $order->getShipDate());
        $this->assertEquals(2, $order->getPaymentMethod());
        $this->assertEquals(1, $order->getStatusId());
        $this->assertEquals([], $order->getItems());
        $this->assertEquals([], $order->getComments());
        $this->assertEquals('Seller Comment', $order->getSellerComment());
        $this->assertEquals('FLATRATE', $order->getShippingProfileId());
        $this->assertEquals('DE1234', $order->getVatId());
        $this->assertEquals('PAY-1234', $order->getPaymentTransactionId());
    }
}
