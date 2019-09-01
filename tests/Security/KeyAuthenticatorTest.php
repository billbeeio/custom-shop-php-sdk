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

namespace Billbee\Tests\CustomShopApi\Security;

use Billbee\CustomShopApi\Http\Request;
use Billbee\CustomShopApi\Http\Uri;
use Billbee\CustomShopApi\Security\AuthenticatorInterface;
use Billbee\CustomShopApi\Security\KeyAuthenticator;
use PHPUnit\Framework\TestCase;

class KeyAuthenticatorTest extends TestCase
{
    public function testConstructor()
    {
        $authenticator = new KeyAuthenticator('1234');
        $this->assertInstanceOf(AuthenticatorInterface::class, $authenticator);
        $this->assertEquals('1234', $authenticator->getKey());
    }

    public function testIsAuthorizedNoKey()
    {
        $uriMock = $this->createMock(Uri::class);
        $uriMock->method('getQuery')
                ->willReturn('');

        $request = $this->createMock(Request::class);
        $request->method('getUri')
                ->willReturn($uriMock);

        $authenticator = new KeyAuthenticator('1234');
        $this->assertFalse($authenticator->isAuthorized($request));
    }

    public function testIsAuthorizedEmpty()
    {
        $uriMock = $this->createMock(Uri::class);
        $uriMock->method('getQuery')
                ->willReturn('Key=');

        $request = $this->createMock(Request::class);
        $request->method('getUri')
                ->willReturn($uriMock);

        $authenticator = new KeyAuthenticator('1234');
        $this->assertFalse($authenticator->isAuthorized($request));
    }

    public function testIsAuthorizedWrongKey()
    {
        $uriMock = $this->createMock(Uri::class);
        $uriMock->method('getQuery')
                ->willReturn('Key=foobar');

        $request = $this->createMock(Request::class);
        $request->method('getUri')
                ->willReturn($uriMock);

        $authenticator = new KeyAuthenticator('1234');
        $this->assertFalse($authenticator->isAuthorized($request));
    }

    public function testIsAuthorizedValidKey()
    {
        $shortenedTimestamp = substr(time(), 0, 7);
        $hash = hash_hmac('sha256', utf8_encode('1234'), utf8_encode($shortenedTimestamp));
        $encodedHash = base64_encode($hash);
        $calculatedKey = str_replace(['=', '/', '+'], '', $encodedHash);

        $uriMock = $this->createMock(Uri::class);
        $uriMock->method('getQuery')
                ->willReturn('Key=' . $calculatedKey);

        $request = $this->createMock(Request::class);
        $request->method('getUri')
                ->willReturn($uriMock);

        $authenticator = new KeyAuthenticator('1234');
        $this->assertTrue($authenticator->isAuthorized($request));
    }
}
