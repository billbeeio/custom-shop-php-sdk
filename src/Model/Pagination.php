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

class Pagination
{
    /**
     * @Serializer\SerializedName("page")
     * @Serializer\Type("int")
     */
    public $page;

    /**
     * @Serializer\SerializedName("totalCount")
     * @Serializer\Type("int")
     */
    public $totalCount;

    /**
     * @Serializer\SerializedName("totalPages")
     * @Serializer\Type("int")
     */
    public $totalPages;

    public function __construct($page = 1, $pageSize = 100, $totalCount = 0)
    {
        $this->page = $page;
        $this->totalPages = ceil($totalCount / $pageSize);
        $this->totalCount = $totalCount;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return mixed
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     * @return mixed
     */
    public function getTotalPages()
    {
        return $this->totalPages;
    }
}
