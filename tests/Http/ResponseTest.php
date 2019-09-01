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

use Billbee\CustomShopApi\Http\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ResponseTest extends TestCase
{
    public function testConstructor()
    {
        $response = new Response('{}', 201, 'Created', ['Cookie' => ['1234']], '1.2');
        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('{}', (string)$response->getBody());
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('Created', $response->getReasonPhrase());
        $this->assertEquals(['Cookie' => ['1234']], $response->getHeaders());
        $this->assertEquals('1.2', $response->getProtocolVersion());
    }

    public function testConstructorWithStreamInterface()
    {
        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')
               ->willReturn('Hello World');

        $response = new Response($stream);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals('Hello World', (string)$response->getBody());
    }

    public function testJson()
    {
        $response = Response::json(['a' => 'b'], 201, 'Created', ['foo' => 'bar'], '1.2');
        $this->assertEquals('{"a":"b"}', (string)$response->getBody());
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('Created', $response->getReasonPhrase());
        $this->assertEquals(['foo' => 'bar', 'content-type' => ['application/json']], $response->getHeaders());
        $this->assertEquals('1.2', $response->getProtocolVersion());
    }

    public function testNotFound()
    {
        $response = Response::notFound('Error', ['foo' => 'bar'], '1.2');
        $this->assertEquals('Error', (string)$response->getBody());
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('Not Found', $response->getReasonPhrase());
        $this->assertEquals(['foo' => 'bar'], $response->getHeaders());
        $this->assertEquals('1.2', $response->getProtocolVersion());
    }

    public function testUnauthorized()
    {
        $response = Response::unauthorized('Error', ['foo' => 'bar'], '1.2');
        $this->assertEquals('Error', (string)$response->getBody());
        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals('Unauthorized', $response->getReasonPhrase());
        $this->assertEquals(['foo' => 'bar'], $response->getHeaders());
        $this->assertEquals('1.2', $response->getProtocolVersion());
    }

    public function testForbidden()
    {
        $response = Response::forbidden('Error', ['foo' => 'bar'], '1.2');
        $this->assertEquals('Error', (string)$response->getBody());
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertEquals('Forbidden', $response->getReasonPhrase());
        $this->assertEquals(['foo' => 'bar'], $response->getHeaders());
        $this->assertEquals('1.2', $response->getProtocolVersion());
    }

    public function testBadRequest()
    {
        $response = Response::badRequest('Error', ['foo' => 'bar'], '1.2');
        $this->assertEquals('Error', (string)$response->getBody());
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('Bad Request', $response->getReasonPhrase());
        $this->assertEquals(['foo' => 'bar'], $response->getHeaders());
        $this->assertEquals('1.2', $response->getProtocolVersion());
    }

    public function testInternalServerError()
    {
        $response = Response::internalServerError('Error', ['foo' => 'bar'], '1.2');
        $this->assertEquals('Error', (string)$response->getBody());
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('Internal Server Error', $response->getReasonPhrase());
        $this->assertEquals(['foo' => 'bar'], $response->getHeaders());
        $this->assertEquals('1.2', $response->getProtocolVersion());
    }

    /**
     * @runInSeparateProcess
     */
    public function testSend()
    {
        $this->assertEquals(1, ob_get_level());

        ob_start();
        $response = Response::unauthorized('Unauthorized', ['foo' => 'bar']);
        $response->send(false);
        $contents = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('Unauthorized', $contents);
        $this->assertEquals(['foo: bar', 'content-length: 12'], xdebug_get_headers());
    }

    public function testWithStatus()
    {
        $response = new Response();
        $this->assertEquals(200, $response->getStatusCode());

        $newResponse = $response->withStatus(400);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(400, $newResponse->getStatusCode());
    }
}
