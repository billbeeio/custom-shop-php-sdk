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

namespace Billbee\CustomShopApi\Model\Response;

use Billbee\CustomShopApi\Model\Order;
use Billbee\CustomShopApi\Model\Pagination;
use JMS\Serializer\Annotation as Serializer;

class GetOrdersResponse
{
    /**
     * @var Pagination
     * @Serializer\SerializedName("paging")
     * @Serializer\Type("Billbee\CustomShopApi\Model\Pagination")
     */
    protected Pagination $paging;

    /**
     * @var Order[]
     * @Serializer\SerializedName("orders")
     * @Serializer\Type("array<Billbee\CustomShopApi\Model\Order>")
     */
    protected array $orders = [];

    /**
     * @param Pagination $paging
     * @param Order[] $orders
     */
    public function __construct(Pagination $paging, $orders = [])
    {
        $this->paging = $paging;
        $this->orders = $orders;
    }

    public function getPaging(): Pagination
    {
        return $this->paging;
    }

    /**
     * @return Order[]
     */
    public function getOrders(): array
    {
        return $this->orders;
    }
}
