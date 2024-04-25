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

use Billbee\CustomShopApi\Http\RequestHandlerInterface;
use Psr\Http\Message\RequestInterface;

abstract class RequestHandlerBase implements RequestHandlerInterface
{
    /** @var string[] */
    protected array $supportedActions = [];

    /** @return array<string, mixed> */
    protected function deserializeBody(RequestInterface $request): array
    {
        $requestBody = (string)$request->getBody();
        parse_str($requestBody, $deserializedBody);
        /** @var array<string, mixed> $deserializedBody */
        return $deserializedBody;
    }

    public function canHandle(RequestInterface $request, array $queryArgs = []): bool
    {
        return in_array($queryArgs['Action'], $this->supportedActions);
    }
}
