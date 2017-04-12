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
namespace Test\Nia\Routing\Facade;

use PHPUnit\Framework\TestCase;
use Nia\Routing\Facade;
use Nia\Routing\Router\Router;
use Nia\Routing\Facade\HttpFacade;
use Nia\Routing\Handler\HandlerInterface;
use Nia\Routing\Filter\FilterInterface;
use Nia\Routing\Filter\CompositeFilterInterface;
use Nia\Routing\Condition\CompositeConditionInterface;
use Nia\Routing\Condition\RegexPathCondition;
use Nia\Routing\Condition\MethodCondition;
use Nia\Routing\Filter\RegexPathContextFillerFilter;
use Nia\Routing\Condition\ConditionInterface;

/**
 * Unit test for \Nia\Routing\Facade\HttpFacade.
 */
class HttpFacadeTest extends TestCase
{

    private $router = null;

    public function setUp()
    {
        $this->router = new Router();
    }

    public function tearDown()
    {
        $this->router = null;
    }

    /**
     * @covers \Nia\Routing\Facade\HttpFacade
     *
     * @dataProvider methodProvider
     */
    public function testGet($method)
    {
        $regex = '#^/$#';
        $handler = $this->createMock(HandlerInterface::class);

        $facade = new HttpFacade($this->router);
        $facade->get($regex, $handler);

        $routes = $this->router->getRoutes();
        $this->assertSame(1, count($routes));

        $route = $routes[0];
        $this->assertSame($handler, $route->getHandler());

        $condition = $route->getCondition();
        /* @var $condition CompositeConditionInterface */
        $this->assertInstanceOf(CompositeConditionInterface::class, $condition);
        $this->assertSame(2, count($condition->getConditions()));
        $this->assertInstanceOf(MethodCondition::class, $condition->getConditions()[0]);
        $this->assertInstanceOf(RegexPathCondition::class, $condition->getConditions()[1]);

        $filter = $route->getFilter();
        /* @var $filter CompositeFilterInterface */
        $this->assertInstanceOf(CompositeFilterInterface::class, $filter);
        $this->assertSame(1, count($filter->getFilters()));
        $this->assertInstanceOf(RegexPathContextFillerFilter::class, $filter->getFilters()[0]);
    }

    /**
     * @covers \Nia\Routing\Facade\HttpFacade
     *
     * @dataProvider methodProvider
     */
    public function testGetOptionals($method)
    {
        $regex = '#^/$#';
        $handler = $this->createMock(HandlerInterface::class);
        $optionalCondition = $this->createMock(ConditionInterface::class);
        $optionalFilter = $this->createMock(FilterInterface::class);

        $facade = new HttpFacade($this->router);
        $facade->get($regex, $handler, $optionalCondition, $optionalFilter);

        $routes = $this->router->getRoutes();
        $this->assertSame(1, count($routes));

        $route = $routes[0];
        $this->assertSame($handler, $route->getHandler());

        $condition = $route->getCondition();
        /* @var $condition CompositeConditionInterface */
        $this->assertInstanceOf(CompositeConditionInterface::class, $condition);
        $this->assertSame(3, count($condition->getConditions()));
        $this->assertInstanceOf(MethodCondition::class, $condition->getConditions()[0]);
        $this->assertInstanceOf(RegexPathCondition::class, $condition->getConditions()[1]);
        $this->assertSame($optionalCondition, $condition->getConditions()[2]);

        $filter = $route->getFilter();
        /* @var $filter CompositeFilterInterface */
        $this->assertInstanceOf(CompositeFilterInterface::class, $filter);
        $this->assertSame(2, count($filter->getFilters()));
        $this->assertInstanceOf(RegexPathContextFillerFilter::class, $filter->getFilters()[0]);
        $this->assertSame($optionalFilter, $filter->getFilters()[1]);
    }

    /**
     * Returns the methods to test.
     */
    public function methodProvider()
    {
        return [
            [
                'get'
            ],
            [
                'post'
            ],
            [
                'put'
            ],
            [
                'patch'
            ],
            [
                'delete'
            ],
            [
                'head'
            ],
            [
                'options'
            ],
            [
                'connect'
            ],
            [
                'trace'
            ]
        ];
    }
}