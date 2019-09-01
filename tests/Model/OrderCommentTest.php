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

namespace Billbee\Tests\CustomShopApi\Model;

use Billbee\CustomShopApi\Model\OrderComment;
use DateTime;
use PHPUnit\Framework\TestCase;

class OrderCommentTest extends TestCase
{
    public function testGettersSetters()
    {
        $comment = new OrderComment();
        $this->assertNull($comment->getDateAdded());
        $this->assertNull($comment->getName());
        $this->assertNull($comment->getComment());
        $this->assertFalse($comment->getFromCustomer());

        $added = new DateTime();

        $comment->setDateAdded($added)
                ->setName('John Doe')
                ->setComment('A Comment')
                ->setFromCustomer(true);

        $this->assertSame($added, $comment->getDateAdded());
        $this->assertEquals('John Doe', $comment->getName());
        $this->assertEquals('A Comment', $comment->getComment());
        $this->assertTrue($comment->getFromCustomer());
    }
}
