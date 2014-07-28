<?php
use BookShare\Book;
use BookShare\Author;
use BookShare\Persistence\Pdo\AllBooks;

require '../vendor/autoload.php';

is_user_logged();

$conn = db_connect();
$sql = <<<QUERY
    SELECT
        a.author_id,
        a.name
     FROM author a
QUERY;
$authors = query_fetch_all($conn, $sql);

