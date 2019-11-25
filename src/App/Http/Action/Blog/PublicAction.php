<?php

namespace App\Http\Action\Blog;

//use framework\Http\Router\Router;
use framework\Http\Router\RouterInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;

class PublicAction
{
	private $router;

	public function __construct(RouterInterface $router) 
	{
		$this->router = $router;
	}

	public function __invoke(ServerRequestInterface $request)
	{
		$id = $request->getAttribute('id'); // извлекаем

		if($id > 5) {
			return new JsonResponse(['error'=>'undefined page'], 404);
		}
		
		// извлекаем пост с таким-то id, 
		// меняем статус поста на "опубликованый" (этот код не написан)
		// и редиректим обратно на страницу этого поста
		return new RedirectResponse($this->router->generate('blog_show', ['id' => $id]));
	}
}