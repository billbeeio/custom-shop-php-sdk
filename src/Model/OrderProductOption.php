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

namespace Billbee\CustomShopApi\Model;

use JMS\Serializer\Annotation as Serializer;

class OrderProductOption
{
    /**
     * @Serializer\SerializedName("name")
     * @Serializer\Type("string")
     */
    public ?string $name;

    /**
     * @Serializer\SerializedName("value")
     * @Serializer\Type("string")
     */
    public ?string $value;

    public function __construct(?string $name = null, ?string $value = null)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): OrderProductOption
    {
        $this->name = $name;
        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): OrderProductOption
    {
        $this->value = $value;
        return $this;
    }
}
