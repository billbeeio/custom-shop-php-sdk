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

use DateTimeInterface;
use JMS\Serializer\Handler\DateHandler;
use JMS\Serializer\Handler\HandlerRegistryInterface;
use JMS\Serializer\SerializerBuilder;
use MintWare\Streams\MemoryStream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @extends Message<Response>
 */
class Response extends Message implements ResponseInterface
{
    protected int $statusCode = 200;

    protected string $reasonPhrase = 'OK';

    /**
     * @param StreamInterface|string|null $body
     * @param int $statusCode
     * @param string $reasonPhrase
     * @param array<array<string>> $headers
     * @param string $protocolVersion
     */
    public function __construct(
        $body = null,
        int $statusCode = 200,
        string $reasonPhrase = 'OK',
        array $headers = [],
        string $protocolVersion = '1.1'
    ) {
        parent::__construct();
        if ($body instanceof StreamInterface) {
            $this->body = $body;
        } elseif (is_string($body)) {
            $this->body = new MemoryStream($body);
        }
        $this->statusCode = $statusCode;
        $this->reasonPhrase = $reasonPhrase;
        $this->headers = $headers;
        $this->protocolVersion = $protocolVersion;
    }

    /**
     * @param mixed $data
     * @param int $statusCode
     * @param string $reasonPhrase
     * @param array<array<string>> $headers
     * @param string $protocolVersion
     * @return Response
     */
    public static function json(
        $data = null,
        int $statusCode = 200,
        string $reasonPhrase = 'OK',
        array $headers = [],
        string $protocolVersion = '1.1'
    ): Response {
        $builder = SerializerBuilder::create();

        if (class_exists('\JMS\Serializer\Visitor\Factory\JsonSerializationVisitorFactory')) {
            $factory = new \JMS\Serializer\Visitor\Factory\JsonSerializationVisitorFactory();
            $factory->setOptions(0);
            $builder = $builder->setSerializationVisitor('json', $factory);
        }
        $serializer = $builder
            ->configureHandlers(function (HandlerRegistryInterface $handlerRegistry) {
                $handlerRegistry->registerSubscribingHandler(new DateHandler(DateTimeInterface::ISO8601));
            })
            ->build();
        $json = $serializer->serialize($data, 'json');
        $headers['content-type'] = ['application/json'];
        return new Response($json, $statusCode, $reasonPhrase, $headers, $protocolVersion);
    }

    /**
     * @param StreamInterface|string|null $body
     * @param array<array<string>> $headers
     * @param string $protocolVersion
     * @return Response
     */
    public static function notFound(
        $body = null,
        array $headers = [],
        string $protocolVersion = '1.1'
    ): Response {
        return new Response($body, 404, 'Not Found', $headers, $protocolVersion);
    }

    /**
     * @param StreamInterface|string|null $body
     * @param array<array<string>> $headers
     * @param string $protocolVersion
     * @return Response
     */
    public static function unauthorized(
        $body = null,
        array $headers = [],
        string $protocolVersion = '1.1'
    ): Response {
        return new Response($body, 401, 'Unauthorized', $headers, $protocolVersion);
    }

    /**
     * @param StreamInterface|string|null $body
     * @param array<array<string>> $headers
     * @param string $protocolVersion
     * @return Response
     */
    public static function forbidden(
        $body = null,
        array $headers = [],
        string $protocolVersion = '1.1'
    ): Response {
        return new Response($body, 403, 'Forbidden', $headers, $protocolVersion);
    }

    /**
     * @param StreamInterface|string|null $body
     * @param array<array<string>> $headers
     * @param string $protocolVersion
     * @return Response
     */
    public static function badRequest(
        $body = null,
        array $headers = [],
        string $protocolVersion = '1.1'
    ): Response {
        return new Response($body, 400, 'Bad Request', $headers, $protocolVersion);
    }

    public static function notImplemented(): Response
    {
        return Response::badRequest('Diese Aktion ist nicht implementiert.');
    }

    /**
     * @param StreamInterface|string|null $body
     * @param array<array<string>> $headers
     * @param string $protocolVersion
     * @return Response
     */
    public static function internalServerError(
        $body = null,
        array $headers = [],
        string $protocolVersion = '1.1'
    ): Response {
        return new Response($body, 500, 'Internal Server Error', $headers, $protocolVersion);
    }

    /**
     * Sends the response to the client
     * @param bool $clearBufferBeforeSend Only for testing purposes
     */
    public function send(bool $clearBufferBeforeSend = true): void
    {
        while ($clearBufferBeforeSend && ob_get_level() > 0) {
            ob_end_clean();
        }
        http_response_code($this->statusCode);

        if (!$this->hasHeader('content-length')) {
            $this->headers['content-length'] = [(string)strlen($this->body)];
        }

        foreach ($this->headers as $header => $val) {
            header("$header: {$this->getHeaderLine($header)}", true);
        }

        echo $this->body;
    }

    /** @inheritDoc */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /** @inheritDoc */
    public function withStatus($code, $reasonPhrase = '')
    {
        $response = clone $this;
        $response->statusCode = $code;
        $response->reasonPhrase = $reasonPhrase;

        return $response;
    }

    /** @inheritDoc */
    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }
}
