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

use Billbee\CustomShopApi\Http\RequestHandlerInterface;
use Psr\Http\Message\RequestInterface;

abstract class RequestHandlerBase implements RequestHandlerInterface
{
    protected $supportedActions = [];

    protected function deserializeBody(RequestInterface $request)
    {
        $requestBody = (string)$request->getBody();
        return json_decode($requestBody, true);
    }

    public function canHandle(RequestInterface $request, $queryArgs = [])
    {
        return in_array($queryArgs['Action'], $this->supportedActions);
    }
}
