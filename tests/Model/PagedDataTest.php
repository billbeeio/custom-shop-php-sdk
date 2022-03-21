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

namespace Billbee\Tests\CustomShopApi\Model;

use Billbee\CustomShopApi\Model\PagedData;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class PagedDataTest extends TestCase
{
    public function testConstructorFailsInvalidCount(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('totalCount must be greater or equal as the count of data.');
        new PagedData([1], 0);
    }

    public function testConstructor(): void
    {
        $pagedData = new PagedData([1], 2);
        $this->assertEquals(2, $pagedData->getTotalCount());
        $this->assertEquals([1], $pagedData->getData());
    }
}
