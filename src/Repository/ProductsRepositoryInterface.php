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
use Billbee\CustomShopApi\Model\PagedData;
use Billbee\CustomShopApi\Model\Product;

interface ProductsRepositoryInterface extends RepositoryInterface
{
    /**
     * Should return the products
     *
     * @param int $page The page, 1 is the first page.
     * @param int $pageSize The number of products per page
     * @return PagedData<Product> A PagedData object which holds the found products
     *
     * @throws NotImplementedException If the method is not implemented
     */
    public function getProducts(int $page, int $pageSize): PagedData;

    /**
     * Returns a single product by the id
     *
     * @param string $productId The id of the product
     * @return Product The product
     *
     * @throws NotImplementedException If the method is not implemented
     * @throws ProductNotFoundException If the product does not exist
     */
    public function getProduct(string $productId): Product;
}
