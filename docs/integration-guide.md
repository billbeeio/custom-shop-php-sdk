# Integration Guide

## 1. Install the package
Install this package using [composer](https://getcomposer.org/):
```shell script
$ composer install billbee/custom-shop-api
```

## 2. Implement the repository classes
This package provides 3 repository classes in the `Billbee\CustomShopApi\Repository` namespace:
- `OrdersRepositoryInterface`
- `ProductsRepositoryInterface`
- `StockSyncRepositoryInterface`
- `ShippingProfileRepositoryInterface`

You need to implement at least the `OrdersRepositoryInterface` interface.

If you implement an interface partially you have to throw an `Billbee\CustomShopApi\Exception\NotImplementedException` in methods which aren't implemented.


## 3. Setup an endpoint
Billbee communicates via HTTP with your shop so you have to define an endpoint.
The endpoint is the URL which is called by Billbee to get orders, set order state get products etc.

For simplicity I use `https://my-shop.tld/billbee.php` as the endpoint in this guide.

The core component of this package is the RequestHandlerPool which reads the request which comes from
Billbee and send it to the correct handler. The handler will call the specific method on the implementation of your
Repository Interface.

So the minimal setup is to instantiate a `RequestHandlerPool` without any authentication and pass a [PSR-7](https://www.php-fig.org/psr/psr-7/) request to it.
```php
<?php
# https://my-shop.tld/billbee.php

use Billbee\CustomShopApi\Http\Request;
use Billbee\CustomShopApi\Http\RequestHandlerPool;

// Create the request handler pool
$authenticator = null;
$handler = new RequestHandlerPool($authenticator, [new YourOrderRepository(), /* More repositories here */]);

// Create a PSR-7 Request from the current HTTP Request and pass it to the handler to retrieve a PSR-7 response
$request = Request::createFromGlobals();
$response = $handler->handle($request);

// Send the response to the client
$response->send();
```

- [Adding Security for Shops](./adding-security-shops.md)
- [Adding Security for Marketplaces](./adding-security-marketplaces.md)
- [Back to index](./index.md)