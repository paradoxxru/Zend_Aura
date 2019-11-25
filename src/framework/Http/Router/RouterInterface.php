<?php

namespace framework\Http\Router;

use framework\Http\Router\Exception\RequestNotMatchedException;
use framework\Http\Router\Exception\RouteNotFoundException;
use Psr\Http\Message\ServerRequestInterface;

interface RouterInterface
{
	/**
	*@param ServerRequestInterface $request
	*@throws RequestNotMatchedException
	*@return Result
	*/
	public function match(ServerRequestInterface $request): Result;

	/**
	*@param $name
	*@param array $params
	*@throws RouteNotFoundException
	*@return string
	*/
	public function generate($name, array $params = []): string;
}