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
    protected $paging;

    /**
     * @var Order[]
     * @Serializer\SerializedName("orders")
     * @Serializer\Type("array<Billbee\CustomShopApi\Model\Order>")
     */
    protected $orders;

    public function __construct(Pagination $paging, $orders = [])
    {
        $this->paging = $paging;
        $this->orders = $orders;
    }

    /**
     * @return Pagination
     */
    public function getPaging()
    {
        return $this->paging;
    }

    /**
     * @return Order[]
     */
    public function getOrders()
    {
        return $this->orders;
    }
}
