<?php

namespace App\Http\Action;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;

class HelloAction
{
	public function __invoke(ServerRequestInterface $request): ResponseInterface
		 {
			$name = $request->getQueryParams()['name'] ?? 'Guest';
		  	return new HtmlResponse('Hello, '.$name. ' !');
		 }
}