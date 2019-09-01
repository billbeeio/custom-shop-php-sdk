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

class ShippingProfile
{
    /**
     * @var string
     * @Serializer\SerializedName("Id")
     * @Serializer\Type("string")
     */
    public $id;

    /**
     * @var string
     * @Serializer\SerializedName("Name")
     * @Serializer\Type("string")
     */
    public $name;

    public function __construct($id = null, $name = null)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return ShippingProfile
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ShippingProfile
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
