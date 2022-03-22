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

namespace Billbee\CustomShopApi\RequestHandler;

use Billbee\CustomShopApi\Http\Response;
use Billbee\CustomShopApi\Repository\ShippingProfileRepositoryInterface;
use Exception;
use Psr\Http\Message\RequestInterface;

class ShippingProfileRequestHandler extends RequestHandlerBase
{
    private ShippingProfileRepositoryInterface $shippingProfileRepository;

    public function __construct(ShippingProfileRepositoryInterface $shippingProfileRepository)
    {
        $this->supportedActions = ['GetShippingProfiles'];
        $this->shippingProfileRepository = $shippingProfileRepository;
    }

    public function handle(RequestInterface $request, array $queryArgs = []): Response
    {
        if ($queryArgs['Action'] == 'GetShippingProfiles') {
            return $this->getShippingProfiles();
        }

        return Response::notImplemented();
    }

    private function getShippingProfiles(): Response
    {
        try {
            $profiles = $this->shippingProfileRepository->getShippingProfiles();
            return Response::json($profiles);
        } catch (Exception $e) {
            return Response::internalServerError($e->getMessage());
        }
    }
}
