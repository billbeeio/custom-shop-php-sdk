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

class OrderProductOption
{
    /**
     * @Serializer\SerializedName("name")
     * @Serializer\Type("string")
     */
    public $name;

    /**
     * @Serializer\SerializedName("value")
     * @Serializer\Type("string")
     */
    public $value;

    public function __construct($name = null, $value = null)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return OrderProductOption
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return OrderProductOption
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}
