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

namespace Billbee\CustomShopApi\Repository;

use Billbee\CustomShopApi\Exception\NotImplementedException;
use Billbee\CustomShopApi\Exception\ProductNotFoundException;
use Exception;

interface StockSyncRepositoryInterface extends RepositoryInterface
{
    /**
     * Sets the current stock of the given product
     *
     * @param string $productId The id of the product for which the stock quantity should be changed
     * @param float $quantity The new available quantity
     * @return void
     *
     * @throws NotImplementedException If the method is not implemented
     * @throws ProductNotFoundException If the product does not exist
     * @throws Exception If something went wrong
     */
    public function setStock(string $productId, float $quantity): void;
}
