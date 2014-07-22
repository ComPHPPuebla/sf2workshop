<?php
require 'config/constants.php';
require 'functions/db.php';
require 'functions/session.php';

is_user_logged();

$conn = db_connect();
$bookId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
$sql = <<<QUERY
    SELECT
        b.filename
     FROM book b
     WHERE book_id = ?
QUERY;
$book = query_fetch_one($conn, $sql, [$bookId]);

$sql = 'UPDATE user SET points = points - ? WHERE username = ?';
query($conn, $sql, [APP_POINTS_DOWNLOAD_BOOK, get_user_information('username')]);

header("Content-disposition: attachment; filename={$book['filename']}");
header("Content-type: application/pdf");
readfile("uploads/{$book['filename']}");
