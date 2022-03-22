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

namespace Billbee\CustomShopApi\Security;

use Psr\Http\Message\RequestInterface;

class KeyAuthenticator implements AuthenticatorInterface
{
    protected string $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function isAuthorized(RequestInterface $request): bool
    {
        parse_str($request->getUri()->getQuery(), $arguments);
        $sentKey = null;
        if (!isset($arguments['Key']) || (!empty($this->key) && empty($sentKey = $arguments['Key']))) {
            return false;
        }

        $shortenedTimestamp = substr((string)time(), 0, 7);
        $hash = hash_hmac('sha256', utf8_encode($this->key), utf8_encode($shortenedTimestamp));
        $encodedHash = base64_encode($hash);
        $calculatedKey = str_replace(['=', '/', '+'], '', $encodedHash);

        return $calculatedKey == $sentKey;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }
}
