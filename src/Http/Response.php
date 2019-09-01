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

use JMS\Serializer\SerializerBuilder;
use MintWare\Streams\MemoryStream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/** @inheritDoc */
class Response extends Message implements ResponseInterface
{
    /** @var int */
    protected $statusCode = 200;

    /** @var string */
    protected $reasonPhrase;

    public function __construct(
        $body = null,
        $statusCode = 200,
        $reasonPhrase = 'OK',
        $headers = [],
        $protocolVersion = '1.1'
    ) {
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

    public static function json(
        $data = null,
        $statusCode = 200,
        $reasonPhrase = 'OK',
        $headers = [],
        $protocolVersion = '1.1'
    ) {
        $serializer = SerializerBuilder::create()->build();
        $json = $serializer->serialize($data, 'json');
        $headers['content-type'] = ['application/json'];
        return new Response($json, $statusCode, $reasonPhrase, $headers, $protocolVersion);
    }

    public static function notFound(
        $body = null,
        $headers = [],
        $protocolVersion = '1.1'
    ) {
        return new Response($body, 404, 'Not Found', $headers, $protocolVersion);
    }

    public static function unauthorized(
        $body = null,
        $headers = [],
        $protocolVersion = '1.1'
    ) {
        return new Response($body, 401, 'Unauthorized', $headers, $protocolVersion);
    }

    public static function forbidden(
        $body = null,
        $headers = [],
        $protocolVersion = '1.1'
    ) {
        return new Response($body, 403, 'Forbidden', $headers, $protocolVersion);
    }

    public static function badRequest(
        $body = null,
        $headers = [],
        $protocolVersion = '1.1'
    ) {
        return new Response($body, 400, 'Bad Request', $headers, $protocolVersion);
    }

    public static function internalServerError(
        $body = null,
        $headers = [],
        $protocolVersion = '1.1'
    ) {
        return new Response($body, 500, 'Internal Server Error', $headers, $protocolVersion);
    }

    /**
     * Sends the response to the client
     * @param bool $clearBufferBeforeSend Only for testing purposes
     */
    public function send($clearBufferBeforeSend = true)
    {
        while ($clearBufferBeforeSend && ob_get_level() > 0) {
            ob_end_clean();
        }
        http_response_code($this->statusCode);

        if (!$this->hasHeader('content-length')) {
            $this->headers['content-length'] = strlen($this->body);
        }

        foreach ($this->headers as $header => $val) {
            header("$header: {$this->getHeaderLine($header)}", true);
        }

        echo $this->body;
    }

    /** @inheritDoc */
    public function getStatusCode()
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
    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }
}
