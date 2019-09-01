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

namespace Billbee\Tests\CustomShopApi\Exception;

use Billbee\CustomShopApi\Exception\NotImplementedException;
use PHPUnit\Framework\TestCase;

class NotImplementedExceptionTest extends TestCase
{
    /** @throws NotImplementedException */
    public function testMessage()
    {
        $this->expectException(NotImplementedException::class);
        $this->expectExceptionMessage('Diese Aktion ist nicht implementiert');
        throw new NotImplementedException();
    }
}
