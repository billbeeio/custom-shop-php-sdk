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

class Pagination
{
    /**
     * @Serializer\SerializedName("page")
     * @Serializer\Type("int")
     */
    public int $page = 1;

    /**
     * @Serializer\SerializedName("totalCount")
     * @Serializer\Type("int")
     */
    public int $totalCount = 0;

    /**
     * @Serializer\SerializedName("totalPages")
     * @Serializer\Type("int")
     */
    public int $totalPages = 0;

    public function __construct(int $page = 1, int $pageSize = 100, int $totalCount = 0)
    {
        $this->page = $page;
        $this->totalPages = (int)ceil($totalCount / $pageSize);
        $this->totalCount = $totalCount;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): Pagination
    {
        $this->page = $page;
        return $this;
    }

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    public function setTotalCount(int $totalCount): Pagination
    {
        $this->totalCount = $totalCount;
        return $this;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function setTotalPages(int $totalPages): Pagination
    {
        $this->totalPages = $totalPages;
        return $this;
    }
}
