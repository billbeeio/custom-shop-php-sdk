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

namespace Billbee\Tests\CustomShopApi\Model;

use Billbee\CustomShopApi\Model\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testGettersSetters()
    {
        $product = new Product();
        $this->assertNull($product->getMaterial());
        $this->assertNull($product->getShortDescription());
        $this->assertNull($product->getBasicAttributes());
        $this->assertNull($product->getDescription());
        $this->assertNull($product->getId());
        $this->assertNull($product->getImages());
        $this->assertNull($product->getTitle());
        $this->assertNull($product->getPrice());
        $this->assertNull($product->getQuantity());
        $this->assertNull($product->getSku());
        $this->assertNull($product->getEan());
        $this->assertNull($product->getManufacturer());
        $this->assertNull($product->getWeightInKg());
        $this->assertNull($product->getVatRate());
        $this->assertNull($product->getLengthInCm());
        $this->assertNull($product->getWidthInCm());
        $this->assertNull($product->getHeightInCm());
        $this->assertNull($product->getCustomFields());
        $this->assertFalse($product->isDigital());

        $product->setMaterial('Material')
                ->setShortDescription('ShortDescription')
                ->setBasicAttributes('BasicAttributes')
                ->setDescription('Description')
                ->setId('Id')
                ->setImages([])
                ->setTitle('Title')
                ->setPrice(2.99)
                ->setQuantity(9)
                ->setSku('Sku')
                ->setEan('Ean')
                ->setManufacturer('Manufacturer')
                ->setWeightInKg(1)
                ->setVatRate(19.00)
                ->setLengthInCm(4)
                ->setWidthInCm(5)
                ->setHeightInCm(6)
                ->setCustomFields([])
                ->setIsDigital(true);

        $this->assertEquals('Material', $product->getMaterial());
        $this->assertEquals('ShortDescription', $product->getShortDescription());
        $this->assertEquals('BasicAttributes', $product->getBasicAttributes());
        $this->assertEquals('Description', $product->getDescription());
        $this->assertEquals('Id', $product->getId());
        $this->assertEquals([], $product->getImages());
        $this->assertEquals('Title', $product->getTitle());
        $this->assertEquals(2.99, $product->getPrice());
        $this->assertEquals(9, $product->getQuantity());
        $this->assertEquals('Sku', $product->getSku());
        $this->assertEquals('Ean', $product->getEan());
        $this->assertEquals('Manufacturer', $product->getManufacturer());
        $this->assertEquals(1, $product->getWeightInKg());
        $this->assertEquals(19.00, $product->getVatRate());
        $this->assertEquals(4, $product->getLengthInCm());
        $this->assertEquals(5, $product->getWidthInCm());
        $this->assertEquals(6, $product->getHeightInCm());
        $this->assertEquals([], $product->getCustomFields());
        $this->assertTrue($product->isDigital());
    }
}
