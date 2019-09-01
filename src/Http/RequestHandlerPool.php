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

use Billbee\CustomShopApi\Repository\OrdersRepositoryInterface;
use Billbee\CustomShopApi\Repository\ProductsRepositoryInterface;
use Billbee\CustomShopApi\Repository\RepositoryInterface;
use Billbee\CustomShopApi\Repository\ShippingProfileRepositoryInterface;
use Billbee\CustomShopApi\Repository\StockSyncRepositoryInterface;
use Billbee\CustomShopApi\RequestHandler\OrderRequestHandler;
use Billbee\CustomShopApi\RequestHandler\ProductRequestHandler;
use Billbee\CustomShopApi\RequestHandler\ShippingProfileRequestHandler;
use Billbee\CustomShopApi\RequestHandler\StockRequestHandler;
use Billbee\CustomShopApi\Security\AuthenticatorInterface;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Psr\Http\Message\RequestInterface;

class RequestHandlerPool
{
    /** @var AuthenticatorInterface */
    private $authenticator;

    /** @var RequestHandlerInterface[] */
    private $requestHandlers = [];

    /**
     * RequestHandlerPool constructor.
     * @param AuthenticatorInterface $authenticator
     * @param RepositoryInterface[] $repositories The repositories
     */
    public function __construct(
        $authenticator,
        $repositories = []
    ) {
        AnnotationRegistry::registerLoader('class_exists');

        $this->authenticator = $authenticator;

        foreach ($repositories as $repository) {
            if ($repository instanceof OrdersRepositoryInterface) {
                $this->requestHandlers[] = new OrderRequestHandler($repository);
            }

            if ($repository instanceof ProductsRepositoryInterface) {
                $this->requestHandlers[] = new ProductRequestHandler($repository);
            }

            if ($repository instanceof StockSyncRepositoryInterface) {
                $this->requestHandlers[] = new StockRequestHandler($repository);
            }

            if ($repository instanceof ShippingProfileRepositoryInterface) {
                $this->requestHandlers[] = new ShippingProfileRequestHandler($repository);
            }
        }
    }

    public function handle(RequestInterface $request)
    {
        parse_str($request->getUri()->getQuery(), $arguments);

        if ($this->authenticator != null && !$this->authenticator->isAuthorized($request)) {
            return Response::unauthorized('Unautorisiert');
        }

        if (!isset($arguments['Action'])) {
            return Response::badRequest('Keine Aktion übergeben.');
        }

        foreach ($this->requestHandlers as $requestHandler) {
            if ($requestHandler->canHandle($request, $arguments)) {
                return $requestHandler->handle($request, $arguments);
            }
        }

        return Response::badRequest('Diese Aktion ist nicht implementiert.');
    }

    /**
     * @return AuthenticatorInterface
     */
    public function getAuthenticator()
    {
        return $this->authenticator;
    }

    /**
     * @return RequestHandlerInterface[]
     */
    public function getRequestHandlers()
    {
        return $this->requestHandlers;
    }
}
