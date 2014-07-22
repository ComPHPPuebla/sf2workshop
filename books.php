<?php
require 'config/constants.php';
require 'functions/db.php';
require 'functions/session.php';

is_user_logged();

$conn = db_connect();
$sql = <<<QUERY
SELECT
    b.book_id,
    b.title,
    COALESCE(SUM(r.rate), 0) / COALESCE(COUNT(r.rate),1) as book_rate
FROM book b
    LEFT JOIN book_rates r
        ON b.book_id = r.book_id
GROUP BY b.book_id
ORDER BY book_rate, b.title
LIMIT 5 OFFSET 0
QUERY;
$books = query_fetch_all($conn, $sql);
?>
<!DOCTYPE html>
<html>
    <head><?php include 'theme/header.phtml' ?></head>
    <body>
        <article class="container">
            <?php include 'theme/navigation.phtml' ?>
            <?php include 'theme/branding.phtml' ?>
            <h2>Top five</h2>
            <table class="table table-striped table-bordered table-hover">
                <tr><th colspan="2">Title</th></tr>
            <?php foreach($books as $book) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <a href="book.php?id=<?php echo (integer) $book['book_id'] ?>">
                            Read now
                        </a>
                    </td>
                <tr>
            <?php endforeach ?>
            </table>
        </article>
        <?php include 'theme/scripts.phtml' ?>
    </body>
</html>
