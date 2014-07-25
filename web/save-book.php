<?php
use BookShare\Book;
use BookShare\Author;
use BookShare\Persistence\Pdo\AllBooks;

require '../vendor/autoload.php';

is_user_logged();

$title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
$authorId = filter_var($_POST['author-id'], FILTER_SANITIZE_STRING);
$filename = $_FILES['file']['name'];

move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $filename);

$conn = db_connect();
$allBooks = new AllBooks($conn);
$allBooks->add(new Book($title, $filename, new Author($authorId)));

$sql = 'UPDATE user SET points = points + ? WHERE username = ?';
query($conn, $sql, [APP_POINTS_SHARE_BOOK, get_user_information('username')]);

header('Location: books.php');
