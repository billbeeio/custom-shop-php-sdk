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

namespace Billbee\Tests\CustomShopApi\Model\Response;

use Billbee\CustomShopApi\Model\Pagination;
use Billbee\CustomShopApi\Model\Response\GetProductsResponse;
use PHPUnit\Framework\TestCase;

class GetProductsResponseTest extends TestCase
{
    public function testConstructor()
    {
        $paging = new Pagination(1, 1, 1);
        $resp = new GetProductsResponse($paging, []);
        $this->assertEquals([], $resp->getProducts());
        $this->assertEquals($paging, $resp->getPaging());
    }
}
