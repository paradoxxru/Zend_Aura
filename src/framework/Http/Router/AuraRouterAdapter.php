<?php

namespace framework\Http\Router;

use Aura\Router\Exception\RouteNotFound;
use Aura\Router\RouterContainer;
use framework\Http\Router\Exception\RequestNotMatchedException;
use framework\Http\Router\Exception\RouteNotFoundException;
use Psr\Http\Message\ServerRequestInterface;

class AuraRouterAdapter implements RouterInterface
{
	private $aura;

	public function __construct(RouterContainer $aura)
	{
		$this->aura = $aura;
	}

	public function match(ServerRequestInterface $request): Result
	{
		// достаем matcher из Aura
		$matcher = $this->aura->getMatcher();
		// если маршрут нашелся
		if ($route = $matcher->match($request)) {
			// то возвращаем результат
			return new Result($route->name, $route->handler, $route->attributes);
		}
		// иначе кидаем свое исключение
		throw new RequestNotMatchedException($request);
	}

	public function generate($name, array $params = []): string
	{
		// из Aura достаем генератор
		$generator = $this->aura->getGenerator();
		try{
			// пробуем сгенерировать маршрут
			return $generator->generate($name, $params);
		} catch(RouteNotFound $e) { // и если прилетело ауровское исключение RouteNotFound
			// то кидаем наше исключение
			throw new RouteNotFoundException($name, $params, $e); // можно также передавать ауровское исключение
			// тогда по логам сможем понять в какой строке ошибка
		}
	}
}