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

use Billbee\CustomShopApi\Model\OrderProduct;
use PHPUnit\Framework\TestCase;

class OrderProductTest extends TestCase
{
    public function testGettersSetters():void
    {
        $product = new OrderProduct();

        $this->assertNull($product->getDiscountPercent());
        $this->assertNull($product->getQuantity());
        $this->assertNull($product->getUnitPrice());
        $this->assertNull($product->getProductId());
        $this->assertNull($product->getName());
        $this->assertNull($product->getSku());
        $this->assertNull($product->getTaxRate());
        $this->assertNull($product->getOptions());

        $product->setDiscountPercent(2.99)
                ->setQuantity(33)
                ->setUnitPrice(15)
                ->setProductId('1234')
                ->setName('A product')
                ->setSku('PRD')
                ->setTaxRate(7.00)
                ->setOptions([]);

        $this->assertEquals(2.99, $product->getDiscountPercent());
        $this->assertEquals(33, $product->getQuantity());
        $this->assertEquals(15, $product->getUnitPrice());
        $this->assertEquals('1234', $product->getProductId());
        $this->assertEquals('A product', $product->getName());
        $this->assertEquals('PRD', $product->getSku());
        $this->assertEquals(7.00, $product->getTaxRate());
        $this->assertEquals([], $product->getOptions());
    }
}
