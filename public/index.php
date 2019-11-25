<?php

use Aura\Router\RouterContainer;
use App\Http\Action;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use framework\Http\Router\Exception\RequestNotMatchedException;
use Zend\Diactoros\Response\JsonResponse;
use framework\Http\Router\AuraRouterAdapter;

chdir(dirname(__DIR__));
require "vendor/autoload.php";

### Initialization
// $routes = new RouteCollection();
// $router = new SimpleRouter($routes);
$aura = new Aura\Router\RouterContainer();
$routes = $aura->getMap();

$routes->get('home', '/', Action\HelloAction::class);
$routes->get('about', '/about', Action\AboutAction::class);
$routes->get('blog', '/blog', Action\Blog\IndexAction::class);
$routes->get('blog_show', '/blog/{id}', Action\Blog\ShowAction::class, ['id' => '\d+']);

$router = new AuraRouterAdapter($aura);
$resolver = new framework\Http\Router\ActionResolver();

$routes->get('blog_public', '/blog/{id}', new Action\Blog\PublicAction($router), ['id' => '\d+']);

### Running
$request = ServerRequestFactory::fromGlobals();
try{
	$result = $router->match($request);
	foreach ($result->getAttributes() as $attribute => $value) {
		$request = $request->withAttribute($attribute, $value);
	}
	$handler = $result->getHandler();
	/**@var callable $action*/
	$action = $resolver->resolve($handler);
	$response = $action($request);

} catch(RequestNotMatchedException $e) {
	$response = new JsonResponse(['error'=>'undefined page'], 404);
}

### Postprocessing
$response = $response->withHeader("X-Developer", "XXXXXXX");

### Sending
$emitter = new SapiEmitter();
$emitter->emit($response);