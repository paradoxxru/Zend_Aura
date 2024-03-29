<?php

namespace framework\Http\Router;

use framework\Http\Router\Exception\RequestNotMatchedException;
use framework\Http\Router\Exception\RouteNotFoundException;
use Psr\Http\Message\ServerRequestInterface;

class Router
{
	private $routes = [];

	public function __construct(RouteCollection $routes)
	{
		$this->routes = $routes;
	}

	public function match(ServerRequestInterface $request): Result
	{
		foreach ($this->routes->getRoutes() as $route) {
			if($result = $route->match($request)) {
				return $result;
			}
		}

		throw new RequestNotMatchedException($request);
	}

	public function generate($name, array $params = []): string
	{
		foreach ($this->routes->getRoutes() as $route) {
			if (null !== $url = $route->generate($name, array_filter($params))) {
				return $url;
			}
		}

		throw new RouteNotFoundException($name, $params);
	}
}