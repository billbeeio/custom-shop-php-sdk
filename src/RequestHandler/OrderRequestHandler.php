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

namespace Billbee\CustomShopApi\RequestHandler;

use Billbee\CustomShopApi\Exception\OrderNotFoundException;
use Billbee\CustomShopApi\Http\Response;
use Billbee\CustomShopApi\Model\Pagination;
use Billbee\CustomShopApi\Model\Response\GetOrdersResponse;
use Billbee\CustomShopApi\Repository\OrdersRepositoryInterface;
use DateTime;
use Exception;
use Psr\Http\Message\RequestInterface;
use stdClass;

class OrderRequestHandler extends RequestHandlerBase
{
    /** @var OrdersRepositoryInterface */
    private $ordersRepository;

    public function __construct(OrdersRepositoryInterface $ordersRepository)
    {
        $this->ordersRepository = $ordersRepository;
        $this->supportedActions = ['GetOrders', 'AckOrder', 'GetOrder', 'SetOrderState'];
    }

    public function handle(RequestInterface $request, $queryArgs = [])
    {
        if (isset($queryArgs['Action'])) {
            if ($queryArgs['Action'] == 'GetOrders') {
                return $this->getOrders($queryArgs);
            }

            if ($queryArgs['Action'] == 'AckOrder') {
                return $this->ackOrder($request);
            }

            if ($queryArgs['Action'] == 'GetOrder') {
                return $this->getOrder($queryArgs);
            }

            if ($queryArgs['Action'] == 'SetOrderState') {
                return $this->setOrderState($request);
            }
        }

        return null;
    }

    private function getOrders($arguments)
    {
        $page = isset($arguments['Page']) ? (int)$arguments['Page'] : 1;
        $pageSize = isset($arguments['PageSize']) ? (int)$arguments['PageSize'] : 1;
        try {
            $startDate = new DateTime(isset($arguments['StartDate']) ? $arguments['StartDate'] : '-30 days');
        } catch (Exception $e) {
            return Response::internalServerError("Der Wert {$arguments['StartDate']} konnte nicht in eine gültiges Datum umgewandelt werden.");
        }

        $pagedData = $this->ordersRepository->getOrders($page, $pageSize, $startDate);
        $paging = new Pagination($page, $pageSize, $pagedData->getTotalCount());

        $response = new GetOrdersResponse($paging, $pagedData->getData());
        return Response::json($response);
    }

    private function ackOrder($request)
    {
        $data = $this->deserializeBody($request);

        if (!isset($data['OrderId']) || empty($orderId = trim($data['OrderId']))) {
            return Response::badRequest('Es wurde keine OrderId übergeben');
        }

        try {
            $this->ordersRepository->acknowledgeOrder($orderId);
            return Response::json(new stdClass());
        } catch (OrderNotFoundException $e) {
            return $this->createOrderNotFoundResponse();
        } catch (Exception $e) {
            return Response::internalServerError($e->getMessage());
        }
    }

    private function getOrder($arguments)
    {
        if (!isset($arguments['OrderId']) || empty($orderId = trim($arguments['OrderId']))) {
            return Response::badRequest('Es wurde keine OrderId übergeben');
        }
        try {
            $order = $this->ordersRepository->getOrder($orderId);
            return Response::json($order);
        } catch (OrderNotFoundException $e) {
            return $this->createOrderNotFoundResponse();
        } catch (Exception $e) {
            return Response::internalServerError($e->getMessage());
        }
    }

    private function setOrderState(RequestInterface $request)
    {
        $data = $this->deserializeBody($request);

        if (!isset($data['OrderId']) || empty($orderId = trim($data['OrderId']))) {
            return Response::badRequest('Es wurde keine OrderId übergeben');
        }

        if (!isset($data['NewStateId']) || empty($newStateId = (int)trim($data['NewStateId']))) {
            return Response::badRequest('Es wurde keine NewStateId übergeben');
        };


        $comment = isset($data['Comment']) ? $data['Comment'] : "";

        try {
            $this->ordersRepository->setOrderState($orderId, $newStateId, $comment);
            return Response::json(new stdClass());
        } catch (OrderNotFoundException $e) {
            return $this->createOrderNotFoundResponse();
        } catch (Exception $e) {
            return Response::internalServerError($e->getMessage());
        }
    }

    /**
     * @return Response
     */
    private function createOrderNotFoundResponse()
    {
        return Response::notFound('Die Bestellung wurde nicht gefunden');
    }
}
