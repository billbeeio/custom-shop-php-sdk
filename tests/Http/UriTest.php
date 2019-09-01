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

use Billbee\CustomShopApi\Http\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;

class UriTest extends TestCase
{
    public function testConstructor()
    {
        $uri = new Uri('https://user:password@php.unit.tld:01337/file.php?param1=foo&param2=bar#fragment');
        $this->assertInstanceOf(UriInterface::class, $uri);

        $this->assertEquals('https', $uri->getScheme());
        $this->assertEquals('user:password', $uri->getUserInfo());
        $this->assertEquals('php.unit.tld', $uri->getHost());
        $this->assertEquals(1337, $uri->getPort());
        $this->assertEquals('/file.php', $uri->getPath());
        $this->assertEquals('param1=foo&param2=bar', $uri->getQuery());
        $this->assertEquals('fragment', $uri->getFragment());
        $this->assertEquals('user:password@php.unit.tld:1337', $uri->getAuthority());
        $this->assertEquals('https://user:password@php.unit.tld:1337/file.php?param1=foo&param2=bar#fragment', (string)$uri);
    }

    public function testWithScheme()
    {
        $uri = new Uri('https://php.unit.tld');
        $this->assertEquals('https', $uri->getScheme());
        $newUri = $uri->withScheme('http');
        $this->assertEquals('https', $uri->getScheme());
        $this->assertEquals('http', $newUri->getScheme());
    }

    public function testUserInfo()
    {
        $uri = new Uri('https://php.unit.tld');
        $this->assertEquals('', $uri->getUserInfo());
        $newUri = $uri->withUserInfo('user', 'password');
        $this->assertEquals('', $uri->getUserInfo());
        $this->assertEquals('user:password', $newUri->getUserInfo());
    }

    public function testWithHost()
    {
        $uri = new Uri('https://php.unit.tld');
        $this->assertEquals('php.unit.tld', $uri->getHost());
        $newUri = $uri->withHost('another.host.tld');
        $this->assertEquals('php.unit.tld', $uri->getHost());
        $this->assertEquals('another.host.tld', $newUri->getHost());
    }

    public function testWithPort()
    {
        $uri = new Uri('https://php.unit.tld');
        $this->assertEquals('', $uri->getPort());
        $newUri = $uri->withPort('01337');
        $this->assertEquals('', $uri->getPort());
        $this->assertEquals(1337, $newUri->getPort());
    }

    public function testWithPath()
    {
        $uri = new Uri('https://php.unit.tld');
        $this->assertEquals('', $uri->getPath());
        $newUri = $uri->withPath('/another.file.php');
        $this->assertEquals('', $uri->getPath());
        $this->assertEquals('/another.file.php', $newUri->getPath());
    }

    public function testWithQuery()
    {
        $uri = new Uri('https://php.unit.tld');
        $this->assertEquals('', $uri->getQuery());
        $newUri = $uri->withQuery('param1=foo&param2=bar');
        $this->assertEquals('', $uri->getQuery());
        $this->assertEquals('param1=foo&param2=bar', $newUri->getQuery());
    }

    public function testWithFragment()
    {
        $uri = new Uri('https://php.unit.tld');
        $this->assertEquals('', $uri->getFragment());
        $newUri = $uri->withFragment('a-fragment');
        $this->assertEquals('', $uri->getFragment());
        $this->assertEquals('a-fragment', $newUri->getFragment());
    }
}
