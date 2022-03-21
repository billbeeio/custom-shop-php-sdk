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

use RuntimeException;

/**
 * @phpstan-template T
 */
class PagedData
{
    /** @var T[]  */
    protected array $data;

    protected int $totalCount;

    /**
     * PagedData constructor.
     * @param T[] $data
     * @param int $totalCount
     */
    public function __construct(array $data = [], int $totalCount = 0)
    {
        $this->data = $data;
        $this->totalCount = $totalCount;

        if ($totalCount < count($this->data)) {
            throw new RuntimeException('totalCount must be greater or equal as the count of data.');
        }
    }

    /**
     * @return T[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }
}
