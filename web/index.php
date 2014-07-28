<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\XmlFileLoader;
use Symfony\Component\Routing\Router;

require '../vendor/autoload.php';

function render_template($template, array $result)
{
    ob_start();
    extract($result, EXTR_SKIP);
    require "../src/BookShareBundle/Resources/views/Book/$template.phtml";

    return ob_get_clean();
}

$request = Request::createFromGlobals();

<<<<<<< HEAD
$locator = new FileLocator(['../src/BookShareBundle/Resources/config']);
=======
$routes = new RouteCollection();
$viewBooks = new Route('/books', ['_controller' => 'view_books']);

$viewBook = new Route(
    '/books/{bookId}',
    ['_controller' => 'view_book'],
    ['bookId' => '\d+']
);
$sharebooks = new Route('/books', ['controller' => 'share_books']);

$downloadBook = new Route(
		'/books/download/{bookId}',
		['_controller' => 'download_book'],
		['bookId' => '\d+']
);

$searchBooks = new Route('/books/search',['_controller' => 'search_books']);
$saveBook = new Route('/books/save',['_controller' => 'save_book']);


$login = new Route('/login', ['_controller' => 'login']);
$logout = new Route('/logout', ['_controller' => 'logout']);
$authenticate = new Route('/authenticate', ['_controller' => 'authenticate']);
$authenticate->setMethods(['POST']);

$routes->add('view-books', $viewBooks);
$routes->add('view-book', $viewBook);
$routes->add('download-book', $downloadBook);
$routes->add('search-books',$searchBooks);
$routes->add('share-book', $sharebooks);
$routes->add('save-book',$saveBook);

$routes->add('login', $login);
$routes->add('logout', $logout);
$routes->add('authenticate', $authenticate);
>>>>>>> upstream/master

$context = new RequestContext();
$context->fromRequest($request);

<<<<<<< HEAD
$router = new Router(
    new XmlFileLoader($locator),
    'routing.xml',
    ['cache_dir' => '../app/cache', 'debug' => true],
    $context
);
=======

$matcher = new UrlMatcher($routes, $context);
>>>>>>> upstream/master

$parameters = $router->match($request->getPathInfo());
$request->attributes->add($parameters);

$result = call_user_func_array($parameters['_controller'], [$request]);
$html = render_template($parameters['_route'], $result);

$response = new Response($html);
$response->prepare($request);
$response->send();
