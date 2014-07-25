<?php
use BookShare\Persistence\Pdo\AllBooks;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require '../vendor/autoload.php';

is_user_logged();

$request = Request::createFromGlobals();

$searchType = $request->request->filter('search-type');
$searchTerm = $request->request->filter('book-search');

$allBooks = new AllBooks(db_connect());

if ('title' === $searchType) {
    $books = $allBooks->ofTitleLike($searchTerm);
} else {
    $books = $allBooks->ofAuthorNameLike($searchTerm);
}

ob_start();
require '../src/BookShareBundle/Resources/views/Book/books-search.phtml';
$html = ob_get_clean();

$response = new Response($html);
$response->prepare($request);
$response->send();

