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

namespace Billbee\CustomShopApi\Http;

use Psr\Http\Message\RequestInterface;

interface RequestHandlerInterface
{
    public function handle(RequestInterface $request, $queryArgs = []);

    public function canHandle(RequestInterface $request, $queryArgs = []);
}
