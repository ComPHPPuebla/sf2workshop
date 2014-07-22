<?php
require 'config/constants.php';
require 'functions/db.php';
require 'functions/session.php';

is_user_logged();

$conn = db_connect();
$filename = filter_var($_GET['file'], FILTER_SANITIZE_STRING);
$sql = <<<QUERY
    SELECT
        b.filename
     FROM book b
     WHERE b.filename = ?
QUERY;

if (!$filename) {
    http_response_code(500);

    return;
}

$book = query_fetch_one($conn, $sql, [$filename]);

header("Content-type: application/pdf");
readfile("uploads/{$book['filename']}");
