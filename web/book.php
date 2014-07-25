<?php
use BookShare\Persistence\Pdo\AllBooks;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require '../vendor/autoload.php';

is_user_logged();

$request = Request::createFromGlobals();
$bookId = $request->query->getInt('id');

$allBooks = new AllBooks(db_connect());
$book = $allBooks->ofBookId($bookId);

ob_start();
require '../src/BookShareBundle/Resources/views/Book/book.phtml';
$html = ob_get_clean();

$response = new Response($html);
$response->prepare($request);
$response->send();
