# Adding security for a marketplace application
If you offer a marketplace application, you might want that your sellers are able to retrieve only their own data (orders, products etc.).
Fortunately, Billbee supports such scenarios by using the basic auth standard.

To integrate this workflow into you application you can create your own `Authenticator` which implements the `AuthenticatorInterface`.
Additionally to this, you've to check the users credentials and store the user information in a "token".

Code Example:

```php
<?php

use Billbee\CustomShopApi\Exception\NotImplementedException;
use Billbee\CustomShopApi\Http\Request;
use Billbee\CustomShopApi\Http\RequestHandlerPool;
use Billbee\CustomShopApi\Repository\OrdersRepositoryInterface;
use Billbee\CustomShopApi\Security\AuthenticatorInterface;
use Psr\Http\Message\RequestInterface;

/** This class is used to store the data of the current user after the isAuthorized check */
class MyToken
{
    public $user;
}

class MyAuthenticator implements AuthenticatorInterface
{
    /** @var MyToken */
    private $myToken;

    /** @var MyUserManager */
    private $myUserManager;

    public function __construct(MyToken $myToken, $myUserManager)
    {
        $this->myToken = $myToken;
        $this->myUserManager = $myUserManager;
    }

    public function isAuthorized(RequestInterface $request)
    {
        // First we extract the user information from the request
        $userInfo = $request->getUri()->getUserInfo();
        list($username, $password) = explode(':', $userInfo, 2);

        // Now you can load the user from your system.
        // Simply return false if the user wasn't found or the credentials are invalid
        $user = $this->myUserManager->findUserByUsername($username);
        if ($user === null) {
            // The user does not exist -> return false
            return false;
        }

        if ($user->password != $password) {
            // The password is wrong
            return false;
        }

        // This step is important:
        // Store the information which is needed by your system to load data from your data source
        // into a "token" object which is passed later to the RepositoryInterface implementations
        $this->myToken->user = $user;

        // Return true if the user has been successfully authenticated 
        return true;
    }
}

// This is your implementation of the OrdersRepositoryInterface
class MyOrderRepository implements OrdersRepositoryInterface
{
    /** @var MyToken */
    private $myToken;

    /** @var MyDataSource */
    private $myDataSource;

    public function __construct(MyToken $myToken, $myDataSource)
    {
        $this->myToken = $myToken;
        $this->myDataSource = $myDataSource;
    }

    /** @inheritDoc */
    public function getOrder($orderId)
    {
        throw new NotImplementedException();
    }

    /** @inheritDoc */
    public function getOrders($page, $pageSize, DateTime $modifiedSince)
    {
        // Retrieve the user which was saved to the token by the Authenticator
        $user = $this->myToken->user;
        // Load user specific data from you data source
        return $this->myDataSource->getOrdersForUserPaged($user, $page, $pageSize, $modifiedSince);
    }

    /** @inheritDoc */
    public function acknowledgeOrder($orderId)
    {
        throw new NotImplementedException();
    }

    /** @inheritDoc */
    public function setOrderState($orderId, $newStateId, $comment)
    {
        throw new NotImplementedException();
    }
}

// Client
$myUserManager = null;
$myDataSource = null;

// Create a new token where the current user is stored to 
$token = new MyToken();

// Check the credentials and store it to the token
$authenticator = new MyAuthenticator($token, $myUserManager);

// Pass the token also to the order repository to restrict the returned orders only to them which belongs to the user
$repository = new MyOrderRepository($token, $myDataSource);

// Create the request handler pool and pass the authenticator and the repository
$handler = new RequestHandlerPool($authenticator, [$repository]);

// Create a PSR-7 Request from the current HTTP Request and pass it to the handler to retrieve a PSR-7 response
$request = Request::createFromGlobals();
$response = $handler->handle($request);

// Send the response to the client
$response->send();
``` 

[Back to index](./index.md)
