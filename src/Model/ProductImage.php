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

class ProductImage
{
    /**
     * @var string
     * @Serializer\SerializedName("url")
     * @Serializer\Type("string")
     */
    public $url;

    /**
     * @var bool
     * @Serializer\SerializedName("isDefault")
     * @Serializer\Type("bool")
     */
    public $isDefault = false;

    /**
     * @var int
     * @Serializer\SerializedName("Position")
     * @Serializer\Type("int")
     */
    public $position;

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return ProductImage
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDefault()
    {
        return $this->isDefault;
    }

    /**
     * @param bool $isDefault
     * @return ProductImage
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;
        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return ProductImage
     */
    public function setPosition($position)
    {
        $this->position = (int)$position;
        return $this;
    }
}
