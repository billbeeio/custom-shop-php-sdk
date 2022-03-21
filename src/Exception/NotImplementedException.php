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

namespace Billbee\CustomShopApi\Exception;

use Exception;
use Throwable;

class NotImplementedException extends Exception
{
    public function __construct(int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Diese Aktion ist nicht implementiert", $code, $previous);
    }
}
