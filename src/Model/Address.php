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

namespace Billbee\CustomShopApi\Model;

use JMS\Serializer\Annotation as Serializer;

class Address
{
    /**
     * @Serializer\SerializedName("firstname")
     * @Serializer\Type("string")
     */
    public $firstName;

    /**
     * @Serializer\SerializedName("lastname")
     * @Serializer\Type("string")
     */
    public $lastName;

    /**
     * @Serializer\SerializedName("street")
     * @Serializer\Type("string")
     */
    public $street;

    /**
     * @Serializer\SerializedName("housenumber")
     * @Serializer\Type("string")
     */
    public $houseNumber;

    /**
     * @Serializer\SerializedName("address2")
     * @Serializer\Type("string")
     */
    public $address2;

    /**
     * @Serializer\SerializedName("postcode")
     * @Serializer\Type("string")
     */
    public $postcode;

    /**
     * @Serializer\SerializedName("city")
     * @Serializer\Type("string")
     */
    public $city;

    /**
     * @Serializer\SerializedName("country_code")
     * @Serializer\Type("string")
     */
    public $countryCode;

    /**
     * @Serializer\SerializedName("company")
     * @Serializer\Type("string")
     */
    public $company;

    /**
     * @Serializer\SerializedName("state")
     * @Serializer\Type("string")
     */
    public $state;

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     * @return Address
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     * @return Address
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    /**
     * @param mixed $houseNumber
     * @return Address
     */
    public function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param mixed $address2
     * @return Address
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param mixed $postcode
     * @return Address
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param mixed $countryCode
     * @return Address
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     * @return Address
     */
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     * @return Address
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }
}
