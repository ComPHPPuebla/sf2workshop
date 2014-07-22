<?php
require 'config/constants.php';
require 'functions/db.php';
require 'functions/session.php';

is_user_logged();

$title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
$authorId = filter_var($_POST['author-id'], FILTER_SANITIZE_STRING);
$filename = $_FILES['file']['name'];

move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $filename);

$sql = 'INSERT INTO book(title, author_id, filename) VALUES (?, ?, ?)';

$conn = db_connect();
query($conn, $sql, [$title, $authorId, $filename]);

$sql = 'UPDATE user SET points = points + ? WHERE username = ?';
query($conn, $sql, [APP_POINTS_SHARE_BOOK, get_user_information('username')]);

header('Location: books.php');
