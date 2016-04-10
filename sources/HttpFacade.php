<?php
/*
 * This file is part of the nia framework architecture.
 *
 * (c) Patrick Ullmann <patrick.ullmann@nat-software.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types = 1);
namespace Nia\Routing\Facade;

use Nia\RequestResponse\Http\HttpRequestInterface;
use Nia\Routing\Condition\CompositeCondition;
use Nia\Routing\Condition\ConditionInterface;
use Nia\Routing\Condition\MethodCondition;
use Nia\Routing\Condition\RegexPathCondition;
use Nia\Routing\Filter\CompositeFilter;
use Nia\Routing\Filter\FilterInterface;
use Nia\Routing\Filter\RegexPathContextFillerFilter;
use Nia\Routing\Handler\HandlerInterface;
use Nia\Routing\Route\RouteInterface;
use Nia\Routing\Route\Route;
use Nia\Routing\Router\RouterInterface;

/**
 * HTTP routing facade to simply add HTTP routes to a given router.
 */
class HttpFacade
{

    /**
     * The used router.
     *
     * @var RouterInterface
     */
    private $router = null;

    /**
     * Constructor.
     *
     * @param RouterInterface $router
     *            The used router.
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Creates a HTTP/GET route.
     *
     * @param string $regex
     *            The regex for the route.
     * @param HandlerInterface $handler
     *            The used handler to handle the match.
     * @param ConditionInterface $condition
     *            Optional condition.
     * @param FilterInterface $filter
     *            Optional filter.
     * @return HttpFacade Reference to this instance.
     */
    public function get($regex, HandlerInterface $handler, ConditionInterface $condition = null, FilterInterface $filter = null): HttpFacade
    {
        $route = $this->createRouteForMethod(HttpRequestInterface::METHOD_GET, $regex, $handler, $condition, $filter);

        $this->router->addRoute($route);

        return $this;
    }

    /**
     * Creates a HTTP/POST route.
     *
     * @param string $regex
     *            The regex for the route.
     * @param HandlerInterface $handler
     *            The used handler to handle the match.
     * @param ConditionInterface $condition
     *            Optional condition.
     * @param FilterInterface $filter
     *            Optional filter.
     * @return HttpFacade Reference to this instance.
     */
    public function post($regex, HandlerInterface $handler, ConditionInterface $condition = null, FilterInterface $filter = null): HttpFacade
    {
        $route = $this->createRouteForMethod(HttpRequestInterface::METHOD_POST, $regex, $handler, $condition, $filter);

        $this->router->addRoute($route);

        return $this;
    }

    /**
     * Creates a HTTP/PUT route.
     *
     * @param string $regex
     *            The regex for the route.
     * @param HandlerInterface $handler
     *            The used handler to handle the match.
     * @param ConditionInterface $condition
     *            Optional condition.
     * @param FilterInterface $filter
     *            Optional filter.
     * @return HttpFacade Reference to this instance.
     */
    public function put($regex, HandlerInterface $handler, ConditionInterface $condition = null, FilterInterface $filter = null): HttpFacade
    {
        $route = $this->createRouteForMethod(HttpRequestInterface::METHOD_PUT, $regex, $handler, $condition, $filter);

        $this->router->addRoute($route);

        return $this;
    }

    /**
     * Creates a HTTP/PATCH route.
     *
     * @param string $regex
     *            The regex for the route.
     * @param HandlerInterface $handler
     *            The used handler to handle the match.
     * @param ConditionInterface $condition
     *            Optional condition.
     * @param FilterInterface $filter
     *            Optional filter.
     * @return HttpFacade Reference to this instance.
     */
    public function patch($regex, HandlerInterface $handler, ConditionInterface $condition = null, FilterInterface $filter = null): HttpFacade
    {
        $route = $this->createRouteForMethod(HttpRequestInterface::METHOD_PATCH, $regex, $handler, $condition, $filter);

        $this->router->addRoute($route);

        return $this;
    }

    /**
     * Creates a HTTP/DELETE route.
     *
     * @param string $regex
     *            The regex for the route.
     * @param HandlerInterface $handler
     *            The used handler to handle the match.
     * @param ConditionInterface $condition
     *            Optional condition.
     * @param FilterInterface $filter
     *            Optional filter.
     * @return HttpFacade Reference to this instance.
     */
    public function delete($regex, HandlerInterface $handler, ConditionInterface $condition = null, FilterInterface $filter = null): HttpFacade
    {
        $route = $this->createRouteForMethod(HttpRequestInterface::METHOD_DELETE, $regex, $handler, $condition, $filter);

        $this->router->addRoute($route);

        return $this;
    }

    /**
     * Creates a HTTP/HEAD route.
     *
     * @param string $regex
     *            The regex for the route.
     * @param HandlerInterface $handler
     *            The used handler to handle the match.
     * @param ConditionInterface $condition
     *            Optional condition.
     * @param FilterInterface $filter
     *            Optional filter.
     * @return HttpFacade Reference to this instance.
     */
    public function head($regex, HandlerInterface $handler, ConditionInterface $condition = null, FilterInterface $filter = null): HttpFacade
    {
        $route = $this->createRouteForMethod(HttpRequestInterface::METHOD_HEAD, $regex, $handler, $condition, $filter);

        $this->router->addRoute($route);

        return $this;
    }

    /**
     * Creates a HTTP/OPTIONS route.
     *
     * @param string $regex
     *            The regex for the route.
     * @param HandlerInterface $handler
     *            The used handler to handle the match.
     * @param ConditionInterface $condition
     *            Optional condition.
     * @param FilterInterface $filter
     *            Optional filter.
     * @return HttpFacade Reference to this instance.
     */
    public function options($regex, HandlerInterface $handler, ConditionInterface $condition = null, FilterInterface $filter = null): HttpFacade
    {
        $route = $this->createRouteForMethod(HttpRequestInterface::METHOD_OPTIONS, $regex, $handler, $condition, $filter);

        $this->router->addRoute($route);

        return $this;
    }

    /**
     * Creates a HTTP/CONNECT route.
     *
     * @param string $regex
     *            The regex for the route.
     * @param HandlerInterface $handler
     *            The used handler to handle the match.
     * @param ConditionInterface $condition
     *            Optional condition.
     * @param FilterInterface $filter
     *            Optional filter.
     * @return HttpFacade Reference to this instance.
     */
    public function connect($regex, HandlerInterface $handler, ConditionInterface $condition = null, FilterInterface $filter = null): HttpFacade
    {
        $route = $this->createRouteForMethod(HttpRequestInterface::METHOD_CONNECT, $regex, $handler, $condition, $filter);

        $this->router->addRoute($route);

        return $this;
    }

    /**
     * Creates a HTTP/TRACE route.
     *
     * @param string $regex
     *            The regex for the route.
     * @param HandlerInterface $handler
     *            The used handler to handle the match.
     * @param ConditionInterface $condition
     *            Optional condition.
     * @param FilterInterface $filter
     *            Optional filter.
     * @return HttpFacade Reference to this instance.
     */
    public function trace($regex, HandlerInterface $handler, ConditionInterface $condition = null, FilterInterface $filter = null): HttpFacade
    {
        $route = $this->createRouteForMethod(HttpRequestInterface::METHOD_TRACE, $regex, $handler, $condition, $filter);

        $this->router->addRoute($route);

        return $this;
    }

    /**
     * Creates a basic route for a method.
     *
     * @param string $method
     *            The used HTTP method.
     *            The regex for the route.
     * @param HandlerInterface $handler
     *            The used handler to handle the match.
     * @param ConditionInterface $condition
     *            Optional condition.
     * @param FilterInterface $filter
     *            Optional filter.
     * @return RouteInterface The created basic route.
     */
    private function createRouteForMethod(string $method, string $regex, HandlerInterface $handler, ConditionInterface $condition = null, FilterInterface $filter = null): RouteInterface
    {
        $conditions = [
            new MethodCondition($method),
            new RegexPathCondition($regex)
        ];

        if ($condition) {
            $conditions[] = $condition;
        }

        $filters = [
            new RegexPathContextFillerFilter($regex)
        ];

        if ($filter) {
            $filters[] = $filter;
        }

        return new Route(new CompositeCondition($conditions), new CompositeFilter($filters), $handler);
    }
}
