# nia - HTTP Routing Facade

HTTP routing facade to simply add HTTP routes to a given router.

## Installation

Require this package with Composer.

```bash
	composer require nia/routing-facade-http
```

## Tests
To run the unit test use the following command:

    $ cd /path/to/nia/component/
    $ phpunit --bootstrap=vendor/autoload.php tests/

## How to use
The following sample shows you how to use the HTTP routing facade component for a common use case.

```php

	$router = new Router();

	// encapsulate the router into the facade.
	$facade = new HttpFacade($router);

	// simple rest handling.
	$facade->get('#^/articles/$#', $articleListHandler);
	$facade->put('#^/articles/$#', $articleUpdateHandler);
	$facade->post('#^/articles/$#', $articleCreateHandler);

	// routes with additional conditions and filters.
	$facade->get('#^/bookmarks/$#', $bookmarkListHandler, $myCondition, $myFilter);
	$facade->put('#^/bookmarks/$#', $bookmarkUpdateHandler, $myCondition, $myFilter);
	$facade->post('#^/bookmarks/$#', $bookmarkCreateHandler, $myCondition, $myFilter);

```
