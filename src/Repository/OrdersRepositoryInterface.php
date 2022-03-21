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

namespace Billbee\CustomShopApi\Repository;

use Billbee\CustomShopApi\Exception\NotImplementedException;
use Billbee\CustomShopApi\Exception\OrderNotFoundException;
use Billbee\CustomShopApi\Model\Order;
use Billbee\CustomShopApi\Model\PagedData;
use DateTime;
use Exception;

interface OrdersRepositoryInterface extends RepositoryInterface
{
    /**
     * Return the order with the given id
     *
     * @param string $orderId The id of the requested order
     * @return Order The order if its exist otherwise null
     *
     * @throws NotImplementedException If the method is not implemented
     * @throws OrderNotFoundException If the order wasn't found
     */
    public function getOrder(string $orderId): Order;

    /**
     * Should return the orders which are created or modified since the $modifiedSince parameter.
     *
     * @param int $page The page, 1 is the first page.
     * @param int $pageSize The number of orders per page
     * @param DateTime $modifiedSince The date from which the orders should be returned.
     * @return PagedData<Order> A PagedData object which holds the found orders
     */
    public function getOrders(int $page, int $pageSize, DateTime $modifiedSince): PagedData;

    /**
     * Billbee calls this method to acknowledge that the order was received
     *
     * @param string $orderId The id of the order which was send
     * @return void
     *
     * @throws NotImplementedException If the method is not implemented
     * @throws OrderNotFoundException If the order was not found
     * @throws Exception If something went wrong
     */
    public function acknowledgeOrder(string $orderId);

    /**
     * Sets the state of an order
     *
     * @param string $orderId The id of the order
     * @param int $newStateId The new state id of the order
     * @param ?string $comment A comment
     * @return void
     *
     * @throws NotImplementedException If the method is not implemented
     * @throws OrderNotFoundException If the order was not found
     * @throws Exception If something went wrong
     */
    public function setOrderState(string $orderId, int $newStateId, ?string $comment);
}
