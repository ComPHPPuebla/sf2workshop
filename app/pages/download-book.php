<?php
use BookShare\Persistence\Pdo\AllBooks;

require '../vendor/autoload.php';

is_user_logged();

$conn = db_connect();
$allBooks = new AllBooks($conn);
$bookId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
$book = $allBooks->ofBookId($bookId);

$sql = 'UPDATE user SET points = points - ? WHERE username = ?';
query($conn, $sql, [APP_POINTS_DOWNLOAD_BOOK, get_user_information('username')]);

header("Content-disposition: attachment; filename={$book['filename']}");
header("Content-type: application/pdf");
readfile("../uploads/{$book['filename']}");
