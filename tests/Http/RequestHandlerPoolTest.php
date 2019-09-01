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

namespace Billbee\Tests\CustomShopApi\Http;

use Billbee\CustomShopApi\Http\Request;
use Billbee\CustomShopApi\Http\RequestHandlerPool;
use Billbee\CustomShopApi\Http\Uri;
use Billbee\CustomShopApi\Model\Order;
use Billbee\CustomShopApi\Repository\OrdersRepositoryInterface;
use Billbee\CustomShopApi\Repository\ProductsRepositoryInterface;
use Billbee\CustomShopApi\Repository\StockSyncRepositoryInterface;
use Billbee\CustomShopApi\RequestHandler\OrderRequestHandler;
use Billbee\CustomShopApi\RequestHandler\ProductRequestHandler;
use Billbee\CustomShopApi\RequestHandler\StockRequestHandler;
use Billbee\CustomShopApi\Security\AuthenticatorInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class RequestHandlerPoolTest extends TestCase
{
    public function testConstructorSimple()
    {
        $orderRepoMock = $this->createMock(OrdersRepositoryInterface::class);
        $rhp = new RequestHandlerPool(null, [$orderRepoMock]);

        $requestHandlers = $rhp->getRequestHandlers();
        $this->assertCount(1, $requestHandlers);
        $this->assertInstanceOf(OrderRequestHandler::class, $requestHandlers[0]);
        $this->assertNull($rhp->getAuthenticator());
    }

    public function testConstructorAdvanced()
    {
        $authMock = $this->createMock(AuthenticatorInterface::class);
        $orderRepoMock = $this->createMock(OrdersRepositoryInterface::class);
        $productRepoMock = $this->createMock(ProductsRepositoryInterface::class);
        $stockSyncRepoMock = $this->createMock(StockSyncRepositoryInterface::class);
        $rhp = new RequestHandlerPool($authMock, [$orderRepoMock, $productRepoMock, $stockSyncRepoMock]);

        $requestHandlers = $rhp->getRequestHandlers();
        $this->assertCount(3, $requestHandlers);
        $this->assertInstanceOf(OrderRequestHandler::class, $requestHandlers[0]);
        $this->assertInstanceOf(ProductRequestHandler::class, $requestHandlers[1]);
        $this->assertInstanceOf(StockRequestHandler::class, $requestHandlers[2]);
        $this->assertInstanceOf(AuthenticatorInterface::class, $rhp->getAuthenticator());
        $this->assertEquals($authMock, $rhp->getAuthenticator());
    }

    public function testHandleFailsUnauthorized()
    {
        $authMock = $this->createMock(AuthenticatorInterface::class);
        $authMock->method('isAuthorized')
                 ->willReturn(false);

        $orderRepoMock = $this->createMock(OrdersRepositoryInterface::class);
        $rhp = new RequestHandlerPool($authMock, [$orderRepoMock]);

        $request = new Request();
        $request = $request->withUri(new Uri('http://foo.bar/index.php'));
        $response = $rhp->handle($request);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals('Unautorisiert', (string)$response->getBody());
    }

    public function testHandleFailsNoAction()
    {
        $authMock = $this->createMock(AuthenticatorInterface::class);
        $authMock->method('isAuthorized')
                 ->willReturn(true);

        $orderRepoMock = $this->createMock(OrdersRepositoryInterface::class);
        $rhp = new RequestHandlerPool($authMock, [$orderRepoMock]);

        $request = new Request();
        $request = $request->withUri(new Uri('http://foo.bar/index.php'));
        $response = $rhp->handle($request);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('Keine Aktion übergeben.', (string)$response->getBody());
    }

    public function testHandleFailsNotImplementedAction()
    {
        $authMock = $this->createMock(AuthenticatorInterface::class);
        $authMock->method('isAuthorized')
                 ->willReturn(true);

        $orderRepoMock = $this->createMock(OrdersRepositoryInterface::class);
        $rhp = new RequestHandlerPool($authMock, [$orderRepoMock]);

        $request = new Request();
        $request = $request->withUri(new Uri('http://foo.bar/index.php?Action=NotImplemented'));
        $response = $rhp->handle($request);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('Diese Aktion ist nicht implementiert.', (string)$response->getBody());
    }

    public function testHandle()
    {
        $authMock = $this->createMock(AuthenticatorInterface::class);
        $authMock->method('isAuthorized')
                 ->willReturn(true);

        $orderRepoMock = $this->createMock(OrdersRepositoryInterface::class);
        $orderRepoMock->method('getOrder')
                      ->willReturn(new Order());

        $rhp = new RequestHandlerPool($authMock, [$orderRepoMock]);

        $request = new Request();
        $request = $request->withUri(new Uri('http://foo.bar/index.php?Action=GetOrder&OrderId=1'));
        $response = $rhp->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('{}', (string)$response->getBody());
    }
}
