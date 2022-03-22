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

use Billbee\CustomShopApi\Model\ShippingProfile;
use PHPUnit\Framework\TestCase;

class ShippingProfileTest extends TestCase
{
    public function testConstructorSimple(): void
    {
        $profile = new ShippingProfile();
        $this->assertNull($profile->getId());
        $this->assertNull($profile->getName());
    }

    public function testConstructorAdvanced(): void
    {
        $profile = new ShippingProfile('Shipper2', 'Shipper 2');
        $this->assertEquals($profile->getId(), 'Shipper2');
        $this->assertEquals($profile->getName(), 'Shipper 2');
    }

    public function testGettersSetters(): void
    {
        $profile = new ShippingProfile();
        $this->assertNull($profile->getId());
        $this->assertNull($profile->getName());

        $profile->setId('shipper1')
            ->setName('Shipper 1');
        $this->assertEquals('shipper1', $profile->getId());
        $this->assertEquals('Shipper 1', $profile->getName());
    }
}
