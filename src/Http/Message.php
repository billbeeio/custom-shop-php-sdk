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

use Psr\Http\Message\StreamInterface;

abstract class Message
{
    protected $protocolVersion = "1.1";

    /** @var string[][] */
    protected $headers = [];

    /** @var StreamInterface */
    protected $body;


    /** @inheritDoc */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    /** @inheritDoc */
    public function withProtocolVersion($version)
    {
        $request = clone $this;
        $request->protocolVersion = $version;

        return $request;
    }

    /** @inheritDoc */
    public function getHeaders()
    {
        return $this->headers;
    }

    /** @inheritDoc */
    public function hasHeader($name)
    {
        return isset($this->headers[$name]);
    }

    /** @inheritDoc */
    public function getHeader($name)
    {
        return $this->headers[$name];
    }

    /** @inheritDoc */
    public function getHeaderLine($name)
    {
        $line = "";

        if ($this->hasHeader($name)) {
            $header = $this->getHeader($name);
            $header = !is_array($header) ? [$header] : $header;
            $line = implode(",", $header);
        }

        return $line;
    }

    /** @inheritDoc */
    public function withHeader($name, $value)
    {
        $request = clone $this;

        $request->headers[$name] = is_array($value) ? $value : [$value];

        return $request;
    }

    /** @inheritDoc */
    public function withAddedHeader($name, $value)
    {
        return $this->withHeader($name, $value);
    }

    /** @inheritDoc */
    public function withoutHeader($name)
    {
        $request = clone $this;

        if ($request->hasHeader($name)) {
            unset($request->headers[$name]);
        }

        return $request;
    }

    /** @inheritDoc */
    public function getBody()
    {
        return $this->body;
    }

    /** @inheritDoc */
    public function withBody(StreamInterface $body)
    {
        $request = clone $this;

        $request->body = $body;

        return $request;
    }
}
