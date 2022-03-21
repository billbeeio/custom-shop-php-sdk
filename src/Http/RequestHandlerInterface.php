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

namespace Billbee\CustomShopApi\Http;

use Psr\Http\Message\RequestInterface;

interface RequestHandlerInterface
{
    /**
     * @param array<string, string> $queryArgs
     */
    public function handle(RequestInterface $request, array $queryArgs = []): Response;

    /**
     * @param array<string, string> $queryArgs
     */
    public function canHandle(RequestInterface $request, array $queryArgs = []): bool;
}
