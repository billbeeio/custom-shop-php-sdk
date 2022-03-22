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

use Billbee\CustomShopApi\Model\OrderProductOption;
use PHPUnit\Framework\TestCase;

class OrderProductOptionTest extends TestCase
{
    public function testConstructor():void
    {
        $productOption = new OrderProductOption('color', 'red');
        $this->assertEquals('color', $productOption->getName());
        $this->assertEquals('red', $productOption->getValue());
    }

    public function testGettersSetters():void
    {
        $productOption = new OrderProductOption();

        $this->assertNull($productOption->getName());
        $this->assertNull($productOption->getValue());

        $productOption->setName('Size')
                      ->setValue('XL');

        $this->assertEquals('Size', $productOption->getName());
        $this->assertEquals('XL', $productOption->getValue());
    }
}
