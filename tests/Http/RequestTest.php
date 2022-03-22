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

namespace Billbee\Tests\CustomShopApi\Http;

use Billbee\CustomShopApi\Http\Request;
use Billbee\CustomShopApi\Http\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class RequestTest extends TestCase
{
    public function testConstructor(): void
    {
        $request = new Request();
        $this->assertInstanceOf(RequestInterface::class, $request);
    }

    public function testCreateFromGlobals(): void
    {
        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.2';
        $_SERVER['HTTPS'] = 1;
        $_SERVER['PHP_AUTH_USER'] = 'user';
        $_SERVER['PHP_AUTH_PW'] = 'password';
        $_SERVER['HTTP_HOST'] = 'php.unit.tld';
        $_SERVER['REQUEST_URI'] = '/index.php?test=foo&bar=baz';
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $request = Request::createFromGlobals();
        $this->assertSame('1.2', $request->getProtocolVersion());
        $this->assertSame('https://user:password@php.unit.tld/index.php?test=foo&bar=baz', (string)$request->getUri());
        $this->assertSame('POST', $request->getMethod());
        $this->assertSame('/index.php', $request->getRequestTarget());
    }

    public function testWithRequestTarget(): void
    {
        $request = new Request();
        $newRequest = $request->withRequestTarget('/foo.php');
        $this->assertSame('/foo.php', $newRequest->getRequestTarget());
    }

    public function testWithMethod(): void
    {
        $request = new Request();
        $newRequest = $request->withMethod('DELETE');
        $this->assertSame('DELETE', $newRequest->getMethod());
    }

    public function testWithUri(): void
    {
        $request = new Request();

        $uri = new Uri('https://php.unit.tld/index.php?test=foo&bar=baz');

        $newRequest = $request->withUri($uri);
        $this->assertSame($uri, $newRequest->getUri());
    }
}
