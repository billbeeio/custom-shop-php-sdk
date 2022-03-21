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

use Billbee\CustomShopApi\Model\Pagination;
use PHPUnit\Framework\TestCase;

class PaginationTest extends TestCase
{
    public function testConstructorSimple(): void
    {
        $pagination = new Pagination();
        $this->assertEquals(1, $pagination->getPage());
        $this->assertEquals(0, $pagination->getTotalCount());
        $this->assertEquals(0, $pagination->getTotalPages());
    }

    public function testConstructorAdvance(): void
    {
        $pagination = new Pagination(1, 50, 100);
        $this->assertEquals(1, $pagination->getPage());
        $this->assertEquals(100, $pagination->getTotalCount());
        $this->assertEquals(2, $pagination->getTotalPages());
    }
}
