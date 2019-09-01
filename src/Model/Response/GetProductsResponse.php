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

namespace Billbee\CustomShopApi\Model\Response;

use Billbee\CustomShopApi\Model\Pagination;
use Billbee\CustomShopApi\Model\Product;
use JMS\Serializer\Annotation as Serializer;

class GetProductsResponse
{
    /**
     * @var Pagination
     * @Serializer\SerializedName("paging")
     * @Serializer\Type("Billbee\CustomShopApi\Model\Pagination")
     */
    protected $paging;

    /**
     * @var Product[]
     * @Serializer\SerializedName("products")
     * @Serializer\Type("array<Billbee\CustomShopApi\Model\Product>")
     */
    protected $products;

    public function __construct($paging, $products)
    {
        $this->paging = $paging;
        $this->products = $products;
    }

    /**
     * @return Pagination
     */
    public function getPaging()
    {
        return $this->paging;
    }

    /**
     * @return Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }
}
