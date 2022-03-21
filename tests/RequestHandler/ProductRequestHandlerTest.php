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

namespace Billbee\Tests\CustomShopApi\RequestHandler;

use Billbee\CustomShopApi\Exception\ProductNotFoundException;
use Billbee\CustomShopApi\Http\Request;
use Billbee\CustomShopApi\Http\Uri;
use Billbee\CustomShopApi\Model\PagedData;
use Billbee\CustomShopApi\Model\Product;
use Billbee\CustomShopApi\Model\ProductImage;
use Billbee\CustomShopApi\Repository\ProductsRepositoryInterface;
use Billbee\CustomShopApi\RequestHandler\ProductRequestHandler;
use Billbee\CustomShopApi\RequestHandler\RequestHandlerBase;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class ProductRequestHandlerTest extends TestCase
{
    public function testConstructor()
    {
        $repo = $this->createMock(ProductsRepositoryInterface::class);

        $handler = new ProductRequestHandler($repo);
        $this->assertInstanceOf(RequestHandlerBase::class, $handler);

        $request = new Request();
        foreach (['GetProduct', 'GetProducts'] as $action) {
            $this->assertTrue($handler->canHandle($request, ['Action' => $action]));
        }
    }

    public function testHandleNonExistent()
    {
        $repo = $this->createMock(ProductsRepositoryInterface::class);
        $handler = new ProductRequestHandler($repo);
        $response = $handler->handle(new Request(), ['Action' => 'asdf']);
        $this->assertNull($response);
    }

    public function testGetProductFailsNoProductId()
    {
        $repo = $this->createMock(ProductsRepositoryInterface::class);
        $handler = new ProductRequestHandler($repo);
        $request = new Request();
        $request = $request->withUri(new Uri('https://foo.bar/index.php?Action=GetProduct'));

        $response = $handler->handle($request, ['Action' => 'GetProduct']);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('Bad Request', $response->getReasonPhrase());
        $this->assertEquals('Es wurde keine ProductId übergeben', (string)$response->getBody());
    }

    public function testGetProductFailsProductNotFound()
    {
        $repo = $this->createMock(ProductsRepositoryInterface::class);
        $repo->method('getProduct')
             ->willThrowException(new ProductNotFoundException());

        $handler = new ProductRequestHandler($repo);
        $request = new Request();
        $request = $request->withUri(new Uri('https://foo.bar/index.php?Action=GetProduct&ProductId=4711'));

        $response = $handler->handle($request, ['Action' => 'GetProduct', 'ProductId' => '4711']);
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('Not Found', $response->getReasonPhrase());
        $this->assertEquals('Der Artikel wurde nicht gefunden', (string)$response->getBody());
    }

    public function testGetProductFailsException()
    {
        $repo = $this->createMock(ProductsRepositoryInterface::class);
        $repo->method('getProduct')
             ->willThrowException(new RuntimeException("Unknown Error"));

        $handler = new ProductRequestHandler($repo);
        $request = new Request();
        $request = $request->withUri(new Uri('https://foo.bar/index.php?Action=GetProduct&ProductId=4711'));

        $response = $handler->handle($request, ['Action' => 'GetProduct', 'ProductId' => '4711']);
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('Internal Server Error', $response->getReasonPhrase());
        $this->assertEquals('Unknown Error', (string)$response->getBody());
    }

    public function testGetProduct()
    {
        $repo = $this->createMock(ProductsRepositoryInterface::class);
        $repo->method('getProduct')
             ->willReturn($this->createDemoProduct());

        $handler = new ProductRequestHandler($repo);
        $request = new Request();
        $request = $request->withUri(new Uri('https://foo.bar/index.php?Action=GetProduct&ProductId=4711'));

        $response = $handler->handle($request, ['Action' => 'GetProduct', 'ProductId' => '4711']);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getReasonPhrase());
        $this->assertEquals(
            '{"material":"Wood","shortdescription":"A chair","basic_attributes":"black, wood","description":"A black wooden chair","id":"4711","images":[{"url":"http:\/\/my.shop.url\/image.jpeg","isDefault":true,"Position":1}],"title":"Black wooden chair","price":29.99,"quantity":12.0,"sku":"CH_BLK","ean":"9876543210789","manufacturer":"Lumberjack  Furnitures","isdigital":false,"weight":5.99,"vat_rate":19.0,"lengthcm":45.0,"widthcm":45.0,"heightcm":120.0,"customfields":{}}',
            (string)$response->getBody()
        );
    }

    public function testGetProductsFailsException()
    {
        $repo = $this->createMock(ProductsRepositoryInterface::class);
        $repo->method('getProducts')
             ->willThrowException(new RuntimeException("Unknown Error"));

        $handler = new ProductRequestHandler($repo);
        $request = new Request();
        $request = $request->withUri(new Uri('https://foo.bar/index.php?Action=GetProducts'));

        $response = $handler->handle($request, ['Action' => 'GetProducts']);
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('Internal Server Error', $response->getReasonPhrase());
        $this->assertEquals('Unknown Error', (string)$response->getBody());
    }

    public function testGetProducts()
    {
        $repo = $this->createMock(ProductsRepositoryInterface::class);
        $repo->method('getProducts')
             ->willReturn(new PagedData([$this->createDemoProduct()], 1));

        $handler = new ProductRequestHandler($repo);
        $request = new Request();
        $request = $request->withUri(new Uri('https://foo.bar/index.php?Action=GetProducts&Page=1&PageSize=1'));


        $response = $handler->handle($request, ['Action' => 'GetProducts']);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getReasonPhrase());
        $json = '{"paging":{"page":1,"totalCount":1,"totalPages":1},"products":[{"material":"Wood","shortdescription":"A chair","basic_attributes":"black, wood","description":"A black wooden chair","id":"4711","images":[{"url":"http:\/\/my.shop.url\/image.jpeg","isDefault":true,"Position":1}],"title":"Black wooden chair","price":29.99,"quantity":12.0,"sku":"CH_BLK","ean":"9876543210789","manufacturer":"Lumberjack  Furnitures","isdigital":false,"weight":5.99,"vat_rate":19.0,"lengthcm":45.0,"widthcm":45.0,"heightcm":120.0,"customfields":{}}]}';
        $this->assertEquals($json, (string)$response->getBody());
    }

    private function createDemoProduct()
    {
        return (new Product())
            ->setMaterial('Wood')
            ->setShortDescription('A chair')
            ->setBasicAttributes('black, wood')
            ->setDescription('A black wooden chair')
            ->setId('4711')
            ->setImages([
                (new ProductImage())
                    ->setUrl('http://my.shop.url/image.jpeg')
                    ->setIsDefault(true)
                    ->setPosition(1)
            ])
            ->setTitle('Black wooden chair')
            ->setPrice(29.99)
            ->setQuantity(12)
            ->setSku('CH_BLK')
            ->setEan('9876543210789')
            ->setManufacturer('Lumberjack  Furnitures')
            ->setIsDigital(false)
            ->setWeightInKg(5.99)
            ->setVatRate(19.0)
            ->setLengthInCm(45)
            ->setWidthInCm(45)
            ->setHeightInCm(120)
            ->setCustomFields([]);
    }
}
