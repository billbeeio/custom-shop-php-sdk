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

namespace Billbee\Tests\CustomShopApi\Model;

use Billbee\CustomShopApi\Model\ProductImage;
use PHPUnit\Framework\TestCase;

class ProductImageTest extends TestCase
{
    public function testGettersSetters()
    {
        $image = new ProductImage();
        $this->assertNull($image->getUrl());
        $this->assertFalse($image->isDefault());
        $this->assertNull($image->getPosition());

        $image->setUrl('http://domain.tld/image.jpeg');
        $image->setIsDefault(true);
        $image->setPosition('3');

        $this->assertSame('http://domain.tld/image.jpeg', $image->getUrl());
        $this->assertTrue($image->isDefault());
        $this->assertSame(3, $image->getPosition());
    }
}
