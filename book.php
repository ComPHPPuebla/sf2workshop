<?php
require 'config/constants.php';
require 'functions/db.php';
require 'functions/session.php';

is_user_logged();

$conn = db_connect();
$bookId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
$sql = <<<QUERY
    SELECT
        b.book_id,
        b.title,
        b.filename,
        a.name AS author
     FROM book b INNER JOIN author a
     ON b.author_id = a.author_id
     WHERE book_id = ?
QUERY;
$book = query_fetch_one($conn, $sql, [$bookId]);
?>
<!DOCTYPE html>
<html>
    <head><?php include 'theme/header.phtml' ?></head>
    <body>
        <article class="container">
            <?php include 'theme/navigation.phtml' ?>
            <?php include 'theme/branding.phtml' ?>
            <h2><?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></h2>
            <h3>By <?php echo htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8') ?></h3>
            <p>
                <a href="view-book.php?file=<?php echo $book['filename'] ?>"
                   class="media" >
                    <?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?>
                </a>
            </p>
            <p>
                <a href="download-book.php?id=<?php echo (integer) $book['book_id'] ?>">Download book</a>
            </p>
            <p>
                <a href="books.php">Back to books</a>
            </p>
        </article>
        <?php include 'theme/scripts.phtml' ?>
        <script type="text/javascript" src="https://raw.githubusercontent.com/malsup/media/master/jquery.media.js"></script>
        <script type="text/javascript" src="https://raw.githubusercontent.com/jquery-orphans/jquery-metadata/master/jquery.metadata.js"></script>
        <script type="text/javascript" src="assets/scripts/book.js"></script>
    </body>
</html>
