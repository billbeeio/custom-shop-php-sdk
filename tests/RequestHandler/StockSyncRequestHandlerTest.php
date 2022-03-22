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

namespace Billbee\Tests\CustomShopApi\RequestHandler;

use Billbee\CustomShopApi\Exception\ProductNotFoundException;
use Billbee\CustomShopApi\Http\Request;
use Billbee\CustomShopApi\Repository\StockSyncRepositoryInterface;
use Billbee\CustomShopApi\RequestHandler\RequestHandlerBase;
use Billbee\CustomShopApi\RequestHandler\StockRequestHandler;
use MintWare\Streams\MemoryStream;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class StockSyncRequestHandlerTest extends TestCase
{
    public function testConstructor(): void
    {
        $repo = $this->createMock(StockSyncRepositoryInterface::class);

        $handler = new StockRequestHandler($repo);
        $this->assertInstanceOf(RequestHandlerBase::class, $handler);

        $request = new Request();
        $this->assertTrue($handler->canHandle($request, ['Action' => 'SetStock']));
    }

    public function testHandleNonExistent(): void
    {
        $repo = $this->createMock(StockSyncRepositoryInterface::class);
        $handler = new StockRequestHandler($repo);
        $response = $handler->handle(new Request(), ['Action' => 'asdf']);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testSetStockFailsNoProductId(): void
    {
        $repo = $this->createMock(StockSyncRepositoryInterface::class);
        $handler = new StockRequestHandler($repo);
        $request = new Request();
        $response = $handler->handle($request, ['Action' => 'SetStock']);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('Bad Request', $response->getReasonPhrase());
        $this->assertEquals('Es wurde keine ProductId übergeben', (string)$response->getBody());
    }

    public function testSetStockFailsNoAvailableStock(): void
    {
        $repo = $this->createMock(StockSyncRepositoryInterface::class);
        $handler = new StockRequestHandler($repo);
        $request = new Request();
        $request = $request->withBody(new MemoryStream(http_build_query(['ProductId' => "4177"])));
        $response = $handler->handle($request, ['Action' => 'SetStock']);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('Bad Request', $response->getReasonPhrase());
        $this->assertEquals('Es wurde kein AvailableStock übergeben', (string)$response->getBody());
    }

    public function testSetStockFailsProductNotFound(): void
    {
        $repo = $this->createMock(StockSyncRepositoryInterface::class);
        $repo->method('SetStock')
            ->willThrowException(new ProductNotFoundException());

        $handler = new StockRequestHandler($repo);
        $request = new Request();
        $request = $request->withBody(
            new MemoryStream(http_build_query(['ProductId' => '4177', "AvailableStock" => 123]))
        );
        $response = $handler->handle($request, ['Action' => 'SetStock']);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('Not Found', $response->getReasonPhrase());
        $this->assertEquals('Der Artikel wurde nicht gefunden', (string)$response->getBody());
    }

    public function testSetStockFailsException(): void
    {
        $repo = $this->createMock(StockSyncRepositoryInterface::class);
        $repo->method('SetStock')
            ->willThrowException(new RuntimeException("Unknown Error"));

        $handler = new StockRequestHandler($repo);
        $request = new Request();
        $request = $request->withBody(
            new MemoryStream(http_build_query(['ProductId' => '4177', "AvailableStock" => 123]))
        );
        $response = $handler->handle($request, ['Action' => 'SetStock']);

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('Internal Server Error', $response->getReasonPhrase());
        $this->assertEquals('Unknown Error', (string)$response->getBody());
    }


    public function testSetStock(): void
    {
        $repo = $this->createMock(StockSyncRepositoryInterface::class);

        $handler = new StockRequestHandler($repo);
        $request = new Request();
        $request = $request->withBody(
            new MemoryStream(http_build_query(['ProductId' => '4177', "AvailableStock" => 123]))
        );
        $response = $handler->handle($request, ['Action' => 'SetStock']);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getReasonPhrase());
        $this->assertEquals('{}', (string)$response->getBody());
    }
}
