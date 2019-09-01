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

use Billbee\CustomShopApi\Http\Request;
use Billbee\CustomShopApi\Model\ShippingProfile;
use Billbee\CustomShopApi\Repository\ShippingProfileRepositoryInterface;
use Billbee\CustomShopApi\RequestHandler\RequestHandlerBase;
use Billbee\CustomShopApi\RequestHandler\ShippingProfileRequestHandler;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class ShippingProfileRequestHandlerTest extends TestCase
{
    public function testConstructor()
    {
        $repo = $this->createMock(ShippingProfileRepositoryInterface::class);

        $handler = new ShippingProfileRequestHandler($repo);
        $this->assertInstanceOf(RequestHandlerBase::class, $handler);

        $request = new Request();
        $this->assertTrue($handler->canHandle($request, ['Action' => 'GetShippingProfiles']));
    }

    public function testHandleNonExistent()
    {
        $repo = $this->createMock(ShippingProfileRepositoryInterface::class);

        $handler = new ShippingProfileRequestHandler($repo);
        $response = $handler->handle(new Request(), ['Action' => 'asdf']);
        $this->assertNull($response);
    }

    public function testSetStockFailsException()
    {
        $repo = $this->createMock(ShippingProfileRepositoryInterface::class);
        $repo->method('getShippingProfiles')
             ->willThrowException(new RuntimeException("Unknown Error"));

        $handler = new ShippingProfileRequestHandler($repo);
        $request = new Request();
        $response = $handler->handle($request, ['Action' => 'GetShippingProfiles']);

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('Internal Server Error', $response->getReasonPhrase());
        $this->assertEquals('Unknown Error', (string)$response->getBody());
    }
    public function testHandle()
    {
        $repo = $this->createMock(ShippingProfileRepositoryInterface::class);

        $repo->method('getShippingProfiles')
             ->willReturn([
                 new ShippingProfile('1', 'Profile 1'),
                 new ShippingProfile('2', 'Profile 2')
             ]);

        $handler = new ShippingProfileRequestHandler($repo);
        $response = $handler->handle(new Request(), ['Action' => 'GetShippingProfiles']);
        $this->assertEquals(200, $response->getStatusCode());

        $json = '[{"Id":"1","Name":"Profile 1"},{"Id":"2","Name":"Profile 2"}]';
        $this->assertEquals($json, (string)$response->getBody());
    }
}
