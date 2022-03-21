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

namespace Billbee\Tests\CustomShopApi\Model\Response;

use Billbee\CustomShopApi\Model\Pagination;
use Billbee\CustomShopApi\Model\Response\GetOrdersResponse;
use PHPUnit\Framework\TestCase;

class GetOrdersResponseTest extends TestCase
{
    public function testConstructor():void
    {
        $paging = new Pagination(1, 1, 1);
        $resp = new GetOrdersResponse($paging, []);
        $this->assertEquals([], $resp->getOrders());
        $this->assertEquals($paging, $resp->getPaging());
    }
}
