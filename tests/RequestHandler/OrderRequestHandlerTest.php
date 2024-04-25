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

use Billbee\CustomShopApi\Exception\OrderNotFoundException;
use Billbee\CustomShopApi\Http\Request;
use Billbee\CustomShopApi\Http\Uri;
use Billbee\CustomShopApi\Model\Address;
use Billbee\CustomShopApi\Model\Order;
use Billbee\CustomShopApi\Model\PagedData;
use Billbee\CustomShopApi\Repository\OrdersRepositoryInterface;
use Billbee\CustomShopApi\RequestHandler\OrderRequestHandler;
use Billbee\CustomShopApi\RequestHandler\RequestHandlerBase;
use DateTime;
use Exception;
use MintWare\Streams\MemoryStream;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class OrderRequestHandlerTest extends TestCase
{
    public function testConstructor(): void
    {
        $repo = $this->createMock(OrdersRepositoryInterface::class);

        $handler = new OrderRequestHandler($repo);
        $this->assertInstanceOf(RequestHandlerBase::class, $handler);

        $request = new Request();
        foreach (['GetOrders', 'AckOrder', 'GetOrder', 'SetOrderState'] as $action) {
            $this->assertTrue($handler->canHandle($request, ['Action' => $action]));
        }
    }

    public function testGetOrders(): void
    {
        $repo = $this->createMock(OrdersRepositoryInterface::class);
        $repo->method('getOrders')
            ->willReturn(new PagedData([$this->createDemoOrder()], 1));
        $handler = new OrderRequestHandler($repo);

        $request = new Request();
        $uri = new Uri('http://localhost/?Action=GetOrders&StartDate=2013-11-28&Page=1&PageSize=100');
        $req = $request->withUri($uri);

        parse_str($uri->getQuery(), $arguments);

        /** @var array<string, string> $arguments */
        $response = $handler->handle($req, $arguments);
        /** @var array{"paging": array{"page": int, "totalPages": int, "totalCount": int}} $data */
        $data = json_decode((string)$response->getBody(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $data['paging']['page']);
        $this->assertEquals(1, $data['paging']['totalPages']);
        $this->assertEquals(1, $data['paging']['totalCount']);
        $body = '{"paging":{"page":1,"totalCount":1,"totalPages":1},"orders":[{"order_id":"1234","order_number":"456","currency_code":"EUR","delivery_source_country_code":"DE","nick_name":"GirlWhoCanFly","ship_cost":4.9,"invoice_address":{"firstname":"Kara","lastname":"Zor-El","street":"Argo Street","housenumber":"1022","address2":"Window","postcode":"90012","city":"National City","country_code":"US","company":"D.E.O.","state":"CA"},"delivery_address":{"firstname":"Kara","lastname":"Zor-El","street":"Argo Street","housenumber":"1022","address2":"Window","postcode":"90012","city":"National City","country_code":"US","company":"D.E.O.","state":"CA"},"order_date":"2019-01-01T20:00:15+0000","email":"secret@deo.tld","phone1":"0123456789","pay_date":"2019-01-01T23:00:15+0000","ship_date":"2019-01-02T02:00:15+0000","payment_method":1,"order_status_id":2,"seller_comment":"Psst","shippingprofile_id":"super-fast","vat_id":"DE-123456","payment_transaction_id":"123444"}]}';
        $this->assertEquals($body, (string)$response->getBody());
    }

    public function testGetOrdersFailsInvalidDAte(): void
    {
        $repo = $this->createMock(OrdersRepositoryInterface::class);
        $repo->method('getOrders')
            ->willReturn(new PagedData([$this->createDemoOrder()], 1));
        $handler = new OrderRequestHandler($repo);

        $request = new Request();
        $uri = new Uri('http://localhost/?Action=GetOrders');
        $req = $request->withUri($uri);

        $response = $handler->handle($req, ['Action' => 'GetOrders', 'StartDate' => 'Hallo Welt']);
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals(
            'Der Wert Hallo Welt konnte nicht in eine gültiges Datum umgewandelt werden.',
            (string)$response->getBody()
        );
    }

    public function testAckOrderFailsNoOrderId(): void
    {
        $repo = $this->createMock(OrdersRepositoryInterface::class);
        $handler = new OrderRequestHandler($repo);

        $request = new Request();
        $uri = new Uri('http://localhost/?Action=AckOrder');
        $req = $request->withUri($uri);

        $response = $handler->handle($req, ['Action' => 'AckOrder']);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('Es wurde keine OrderId übergeben', (string)$response->getBody());
    }

    public function testAckOrderFailsNotFound(): void
    {
        $repo = $this->createMock(OrdersRepositoryInterface::class);
        $repo->method('acknowledgeOrder')
            ->willThrowException(new OrderNotFoundException());
        $handler = new OrderRequestHandler($repo);

        /** @var RequestInterface $request */
        $request = new Request();
        $uri = new Uri('http://localhost/?Action=AckOrder');
        $req = $request->withUri($uri)
            ->withBody(new MemoryStream(http_build_query(['OrderId' => '1'])));

        $response = $handler->handle($req, ['Action' => 'AckOrder']);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('Die Bestellung wurde nicht gefunden', (string)$response->getBody());
    }

    public function testAckOrderFailsUnknownError(): void
    {
        $repo = $this->createMock(OrdersRepositoryInterface::class);
        $repo->method('acknowledgeOrder')
            ->willThrowException(new Exception('Unknown Error'));
        $handler = new OrderRequestHandler($repo);

        /** @var RequestInterface $request */
        $request = new Request();
        $uri = new Uri('http://localhost/?Action=AckOrder&OrderId=1');
        $req = $request->withUri($uri)
            ->withBody(new MemoryStream(http_build_query(['OrderId' => '1'])));


        $response = $handler->handle($req, ['Action' => 'AckOrder']);

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('Unknown Error', (string)$response->getBody());
    }

    public function testAckOrder(): void
    {
        $repo = $this->createMock(OrdersRepositoryInterface::class);
        $repo->method('acknowledgeOrder')
            ->willReturn(null);
        $handler = new OrderRequestHandler($repo);

        /** @var RequestInterface $request */
        $request = new Request();
        $uri = new Uri('http://localhost/?Action=AckOrder&OrderId=1');
        $req = $request->withUri($uri)
            ->withBody(new MemoryStream(http_build_query(['OrderId' => '1'])));


        $response = $handler->handle($req, ['Action' => 'AckOrder']);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetOrderFailsNoOrderId(): void
    {
        $repo = $this->createMock(OrdersRepositoryInterface::class);
        $handler = new OrderRequestHandler($repo);

        $request = new Request();
        $uri = new Uri('http://localhost/?Action=GetOrder');
        $req = $request->withUri($uri);

        $response = $handler->handle($req, ['Action' => 'GetOrder']);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('Es wurde keine OrderId übergeben', (string)$response->getBody());
    }

    public function testGetOrderFailsNotFound(): void
    {
        $repo = $this->createMock(OrdersRepositoryInterface::class);
        $repo->method('getOrder')
            ->willThrowException(new OrderNotFoundException());
        $handler = new OrderRequestHandler($repo);

        $request = new Request();
        $uri = new Uri('http://localhost/?Action=GetOrder&OrderId=1');
        $req = $request->withUri($uri);

        $response = $handler->handle($req, ['Action' => 'GetOrder', 'OrderId' => '1']);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('Die Bestellung wurde nicht gefunden', (string)$response->getBody());
    }

    public function testGetOrderFailsUnknownError(): void
    {
        $repo = $this->createMock(OrdersRepositoryInterface::class);
        $repo->method('getOrder')
            ->willThrowException(new Exception('Unknown Error'));
        $handler = new OrderRequestHandler($repo);

        $request = new Request();
        $uri = new Uri('http://localhost/?Action=GetOrder&OrderId=1');
        $req = $request->withUri($uri);

        $response = $handler->handle($req, ['Action' => 'GetOrder', 'OrderId' => '1']);

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('Unknown Error', (string)$response->getBody());
    }

    public function testGetOrder(): void
    {
        $repo = $this->createMock(OrdersRepositoryInterface::class);
        $repo->method('getOrder')
            ->willReturn($this->createDemoOrder());

        $handler = new OrderRequestHandler($repo);

        $request = new Request();
        $uri = new Uri('http://localhost/?Action=GetOrder&OrderId=1');
        $req = $request->withUri($uri);

        $response = $handler->handle($req, ['Action' => 'GetOrder', 'OrderId' => '1']);

        $this->assertEquals(200, $response->getStatusCode());
        $bodyJson = '{"order_id":"1234","order_number":"456","currency_code":"EUR","delivery_source_country_code":"DE","nick_name":"GirlWhoCanFly","ship_cost":4.9,"invoice_address":{"firstname":"Kara","lastname":"Zor-El","street":"Argo Street","housenumber":"1022","address2":"Window","postcode":"90012","city":"National City","country_code":"US","company":"D.E.O.","state":"CA"},"delivery_address":{"firstname":"Kara","lastname":"Zor-El","street":"Argo Street","housenumber":"1022","address2":"Window","postcode":"90012","city":"National City","country_code":"US","company":"D.E.O.","state":"CA"},"order_date":"2019-01-01T20:00:15+0000","email":"secret@deo.tld","phone1":"0123456789","pay_date":"2019-01-01T23:00:15+0000","ship_date":"2019-01-02T02:00:15+0000","payment_method":1,"order_status_id":2,"seller_comment":"Psst","shippingprofile_id":"super-fast","vat_id":"DE-123456","payment_transaction_id":"123444"}';
        $this->assertEquals($bodyJson, (string)$response->getBody());
    }

    public function testSetOrderStateFailsNoOrderId(): void
    {
        $repo = $this->createMock(OrdersRepositoryInterface::class);
        $handler = new OrderRequestHandler($repo);

        $request = new Request();
        $uri = new Uri('http://localhost/?Action=SetOrderState');
        $req = $request->withUri($uri);

        $response = $handler->handle($req, ['Action' => 'SetOrderState']);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('Es wurde keine OrderId übergeben', (string)$response->getBody());
    }

    public function testSetOrderStateFailsNoNewStateTypeId(): void
    {
        $repo = $this->createMock(OrdersRepositoryInterface::class);
        $handler = new OrderRequestHandler($repo);

        /** @var RequestInterface $request */
        $request = new Request();
        $uri = new Uri('http://localhost/?Action=SetOrderState');
        $req = $request->withUri($uri)->withBody(new MemoryStream(http_build_query(['OrderId' => '1'])));

        $response = $handler->handle($req, ['Action' => 'SetOrderState']);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('Es wurde keine NewStateTypeId übergeben', (string)$response->getBody());
    }

    public function testSetOrderStateFailsNotFound(): void
    {
        $repo = $this->createMock(OrdersRepositoryInterface::class);
        $repo->method('setOrderState')
            ->willThrowException(new OrderNotFoundException());
        $handler = new OrderRequestHandler($repo);

        /** @var RequestInterface $request */
        $request = new Request();
        $uri = new Uri('http://localhost/?Action=SetOrderState');
        $req = $request->withUri($uri)->withBody(
            new MemoryStream(http_build_query(['OrderId' => 1, 'NewStateTypeId' => 1]))
        );

        $response = $handler->handle($req, ['Action' => 'SetOrderState']);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('Die Bestellung wurde nicht gefunden', (string)$response->getBody());
    }

    public function testSetOrderStateUnknownError(): void
    {
        $repo = $this->createMock(OrdersRepositoryInterface::class);
        $repo->method('setOrderState')
            ->willThrowException(new Exception('Unknown Error'));
        $handler = new OrderRequestHandler($repo);

        /** @var RequestInterface $request */
        $request = new Request();
        $uri = new Uri('http://localhost/?Action=SetOrderState');
        $req = $request->withUri($uri)->withBody(
            new MemoryStream(http_build_query(['OrderId' => 1, 'NewStateTypeId' => 1]))
        );

        $response = $handler->handle($req, ['Action' => 'SetOrderState', 'OrderId' => '1']);

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('Unknown Error', (string)$response->getBody());
    }

    public function testSetOrderState(): void
    {
        $repo = $this->createMock(OrdersRepositoryInterface::class);
        $repo->method('setOrderState')
            ->willReturn(true);
        $handler = new OrderRequestHandler($repo);

        /** @var RequestInterface $request */
        $request = new Request();
        $uri = new Uri('http://localhost/?Action=SetOrderState');
        $req = $request->withUri($uri)->withBody(
            new MemoryStream(http_build_query(['OrderId' => 1, 'NewStateTypeId' => 1]))
        );

        $response = $handler->handle($req, ['Action' => 'SetOrderState', 'OrderId' => '1']);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testHandleNonExistent(): void
    {
        $repo = $this->createMock(OrdersRepositoryInterface::class);
        $handler = new OrderRequestHandler($repo);
        $response = $handler->handle(new Request(), ['Action' => 'asdf']);
        $this->assertEquals(400, $response->getStatusCode());
    }

    private function createDemoOrder(): Order
    {
        $address = (new Address())
            ->setFirstName('Kara')
            ->setLastName('Zor-El')
            ->setStreet('Argo Street')
            ->setHouseNumber('1022')
            ->setAddress2('Window')
            ->setPostcode('90012')
            ->setCity('National City')
            ->setCountryCode('US')
            ->setCompany('D.E.O.')
            ->setState('CA');
        return (new Order())
            ->setOrderId('1234')
            ->setOrderNumber('456')
            ->setCurrencyCode('EUR')
            ->setDeliverySourceCountryCode('DE')
            ->setNickName('GirlWhoCanFly')
            ->setShipCost(4.90)
            ->setInvoiceAddress($address)
            ->setDeliveryAddress($address)
            ->setOrderDate(new DateTime('2019-01-01T20:00:15'))
            ->setEmail('secret@deo.tld')
            ->setPhone1('0123456789')
            ->setPayDate(new DateTime('2019-01-01T23:00:15'))
            ->setShipDate(new DateTime('2019-01-02T02:00:15'))
            ->setPaymentMethod(1)
            ->setStatusId(2)
            ->setSellerComment('Psst')
            ->setShippingProfileId('super-fast')
            ->setVatId('DE-123456')
            ->setPaymentTransactionId('123444');
    }
}
