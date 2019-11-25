<?php
namespace framework\Http\Router;

use framework\Http\Router\Route\RegexpRoute;
use framework\Http\Router\Route\Route;

class RouteCollection
{
	private $routes = [];

	public function addRoute(Route $route): void
	{
		$this->routes[] = $route;
	}

	public function any($name, $pattern, $handler, array $tokens = []): void
	{
		$this->addRoute(new RegexpRoute($name, $pattern, $handler, [], $tokens));
	}
	public function add($name, $pattern, $handler,array $methods, array $tokens = []): void
	{
		$this->addRoute(new RegexpRoute($name, $pattern, $handler, $methods, $tokens));
	}
	public function get($name, $pattern, $handler, array $tokens = []): void
	{
		$this->addRoute(new RegexpRoute($name, $pattern, $handler, ['GET'], $tokens));
	}
	public function post($name, $pattern, $handler, array $tokens = []): void
	{
		$this->addRoute(new RegexpRoute($name, $pattern, $handler, ['POST'], $tokens));
	}
								
	/*@return Route[]
	*/
	public function getRoutes(): array
	{
		return $this->routes;
	}
}