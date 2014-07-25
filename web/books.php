<?php
use BookShare\Persistence\Pdo\AllBooks;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require '../vendor/autoload.php';

is_user_logged();

$request = Request::createFromGlobals();

$allBooks = new AllBooks(db_connect());
$books = $allBooks->withBestRate();

ob_start();
require '../src/BookShareBundle/Resources/views/Book/books.phtml';
$html = ob_get_clean();

$response = new Response($html);
$response->prepare($request);
$response->send();
