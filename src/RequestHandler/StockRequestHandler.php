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

use Billbee\CustomShopApi\Exception\ProductNotFoundException;
use Billbee\CustomShopApi\Http\Response;
use Billbee\CustomShopApi\Repository\StockSyncRepositoryInterface;
use Exception;
use Psr\Http\Message\RequestInterface;
use stdClass;

class StockRequestHandler extends RequestHandlerBase
{
    /** @var StockSyncRepositoryInterface */
    private $stockSyncRepository;

    public function __construct(StockSyncRepositoryInterface $stockSyncRepository)
    {
        $this->stockSyncRepository = $stockSyncRepository;
        $this->supportedActions = ['SetStock'];
    }

    public function handle(RequestInterface $request, $queryArgs = [])
    {
        if ($queryArgs['Action'] == 'SetStock') {
            return $this->setStock($request);
        }

        return null;
    }

    private function setStock(RequestInterface $request)
    {
        $data = $this->deserializeBody($request);
        if (!isset($data['ProductId']) || empty($productId = trim($data['ProductId']))) {
            return Response::badRequest('Es wurde keine ProductId übergeben');
        }

        if (!isset($data['AvailableStock']) || empty($availableStock = (float)trim($data['AvailableStock']))) {
            return Response::badRequest('Es wurde kein AvailableStock übergeben');
        };

        try {
            $this->stockSyncRepository->setStock($productId, $availableStock);
            return Response::json(new stdClass());
        } catch (ProductNotFoundException $e) {
            return Response::notFound('Der Artikel wurde nicht gefunden');
        } catch (Exception $e) {
            return Response::internalServerError($e->getMessage());
        }
    }
}
