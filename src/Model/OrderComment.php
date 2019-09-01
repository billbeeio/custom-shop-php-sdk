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

class OrderComment
{
    /**
     * @Serializer\SerializedName("date_added")
     * @Serializer\Type("DateTime")
     */
    public $dateAdded;

    /**
     * @Serializer\SerializedName("name")
     * @Serializer\Type("string")
     */
    public $name;

    /**
     * @Serializer\SerializedName("comment")
     * @Serializer\Type("string")
     */
    public $comment;

    /**
     * @Serializer\SerializedName("from_customer")
     * @Serializer\Type("bool")
     */
    public $fromCustomer = false;

    /**
     * @return mixed
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @param mixed $dateAdded
     * @return OrderComment
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;
        return $this;
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
     * @return OrderComment
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     * @return OrderComment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFromCustomer()
    {
        return $this->fromCustomer;
    }

    /**
     * @param mixed $fromCustomer
     * @return OrderComment
     */
    public function setFromCustomer($fromCustomer)
    {
        $this->fromCustomer = $fromCustomer;
        return $this;
    }
}
