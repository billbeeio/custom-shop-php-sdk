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

use Billbee\CustomShopApi\Model\Address;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    public function testGettersSetters(): void
    {
        $address = new Address();
        $this->assertNull($address->getFirstName());
        $this->assertNull($address->getLastName());
        $this->assertNull($address->getStreet());
        $this->assertNull($address->getHouseNumber());
        $this->assertNull($address->getAddress2());
        $this->assertNull($address->getPostcode());
        $this->assertNull($address->getCity());
        $this->assertNull($address->getCountryCode());
        $this->assertNull($address->getCompany());
        $this->assertNull($address->getState());

        $address->setFirstName('FirstName')
            ->setLastName('LastName')
            ->setStreet('Street')
            ->setHouseNumber('HouseNumber')
            ->setAddress2('Address2')
            ->setPostcode('Postcode')
            ->setCity('City')
            ->setCountryCode('CountryCode')
            ->setCompany('Company')
            ->setState('State');

        $this->assertEquals('FirstName', $address->getFirstName());
        $this->assertEquals('LastName', $address->getLastName());
        $this->assertEquals('Street', $address->getStreet());
        $this->assertEquals('HouseNumber', $address->getHouseNumber());
        $this->assertEquals('Address2', $address->getAddress2());
        $this->assertEquals('Postcode', $address->getPostcode());
        $this->assertEquals('City', $address->getCity());
        $this->assertEquals('CountryCode', $address->getCountryCode());
        $this->assertEquals('Company', $address->getCompany());
        $this->assertEquals('State', $address->getState());
    }
}
