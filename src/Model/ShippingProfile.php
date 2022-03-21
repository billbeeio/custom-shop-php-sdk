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

class ShippingProfile
{
    /**
     * @Serializer\SerializedName("Id")
     * @Serializer\Type("string")
     */
    public ?string $id = null;

    /**
     * @Serializer\SerializedName("Name")
     * @Serializer\Type("string")
     */
    public ?string $name = null;

    public function __construct(?string $id = null, ?string $name = null)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): ShippingProfile
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): ShippingProfile
    {
        $this->name = $name;
        return $this;
    }
}
