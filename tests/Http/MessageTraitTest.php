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

use Billbee\CustomShopApi\Http\Message;
use MintWare\Streams\MemoryStream;
use PHPUnit\Framework\TestCase;

class MessageTraitTest extends TestCase
{
    public function testConstructor()
    {
        $mock = $this->getMockForAbstractClass(Message::class);

        $this->assertSame('1.1', $mock->getProtocolVersion());
        $this->assertSame([], $mock->getHeaders());
        $this->assertNull($mock->getBody());
    }

    public function testWithProtocolVersion()
    {
        $mock = $this->getMockForAbstractClass(Message::class);
        $newTrait = $mock->withProtocolVersion('1.2');
        $this->assertEquals('1.2', $newTrait->getProtocolVersion());
    }

    public function testHeaders()
    {
        $mock = $this->getMockForAbstractClass(Message::class);
        $this->assertFalse($mock->hasHeader('foo'));
        $this->assertEmpty($mock->getHeaders());
        $newTrait = $mock->withHeader('foo', 'bar');
        $this->assertTrue($newTrait->hasHeader('foo'));
        $this->assertEquals(['foo' => ['bar']], $newTrait->getHeaders());
        $this->assertEquals(['bar'], $newTrait->getHeader('foo'));
        $this->assertEquals('bar', $newTrait->getHeaderLine('foo'));

        $newTrait = $mock->withHeader('foo', ['bar', 'baz']);
        $this->assertTrue($newTrait->hasHeader('foo'));
        $this->assertEquals(['foo' => ['bar', 'baz']], $newTrait->getHeaders());
        $this->assertEquals(['bar', 'baz'], $newTrait->getHeader('foo'));
        $this->assertEquals('bar,baz', $newTrait->getHeaderLine('foo'));

        $newTrait = $newTrait->withAddedHeader('baz', 'bar');
        $this->assertTrue($newTrait->hasHeader('foo'));
        $this->assertTrue($newTrait->hasHeader('baz'));

        $newTrait = $newTrait->withoutHeader('foo');
        $this->assertFalse($newTrait->hasHeader('foo'));
        $this->assertTrue($newTrait->hasHeader('baz'));
    }

    public function testWithBody()
    {
        $mock = $this->getMockForAbstractClass(Message::class);
        $streamMock = $this->createMock(MemoryStream::class);

        $newMock = $mock->withBody($streamMock);
        $this->assertSame($streamMock, $newMock->getBody());
    }
}
