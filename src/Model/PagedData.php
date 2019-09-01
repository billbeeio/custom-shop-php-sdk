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

use RuntimeException;

class PagedData
{
    /** @var array */
    protected $data;

    /** @var int */
    protected $totalCount;

    /**
     * PagedData constructor.
     * @param array $data
     * @param int $totalCount
     */
    public function __construct(array $data = [], $totalCount = 0)
    {
        $this->data = $data;
        $this->totalCount = $totalCount;

        if ($totalCount < count($this->data)) {
            throw new RuntimeException('totalCount must be greater or equal as the count of data.');
        }
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }
}
