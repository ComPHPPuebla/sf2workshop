<?php
namespace BookShare\Persistence\Pdo;

use BookShare\AllBooks as AllBooksInterface;
use BookShare\Book;
use PDO;

class AllBooks implements AllBooksInterface
{
    /** @type PDO */
    protected $connection;

    /**
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param  integer $bookId
     * @return Book
     */
    public function ofBookId($bookId)
    {
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
        $statement = $this->connection->prepare($sql);
        $statement->execute([$bookId]);

        return $statement->fetch();
    }

    /**
     * @param  string  $title
     * @return Books[]
     */
    public function ofTitleLike($title)
    {
        $sql = <<<QUERY
SELECT
    b.book_id,
    b.title,
    COALESCE(SUM(r.rate), 0) / COALESCE(COUNT(r.rate),1) as book_rate
FROM book b
    LEFT JOIN book_rates r
        ON b.book_id = r.book_id
WHERE b.title LIKE '%$title%'
GROUP BY b.book_id
ORDER BY book_rate, b.title
QUERY;
        $statement = $this->connection->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * @param  string  $authorName
     * @return Books[]
    */
    public function ofAuthorNameLike($authorName)
    {
        $sql = <<<QUERY
SELECT
    b.book_id,
    b.title,
    COALESCE(SUM(r.rate), 0) / COALESCE(COUNT(r.rate),1) as book_rate
FROM book b
    INNER JOIN author a
        ON b.author_id = a.author_id
    LEFT JOIN book_rates r
        ON b.book_id = r.book_id
WHERE a.name LIKE '%$authorName%'
GROUP BY b.book_id
ORDER BY book_rate, b.title
QUERY;
        $statement = $this->connection->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * @param Book $book
     */
    public function add(Book $book)
    {
        $sql = 'INSERT INTO book(title, author_id, filename) VALUES (?, ?, ?)';
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            $book->title(), $book->authorId(), $book->filename(),
        ]);

        return $statement->rowCount();
    }

    public function withBestRate()
    {
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
        $statement = $this->connection->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function allAuthors()
    {
        $sql = <<<QUERY
            SELECT
                a.author_id,
                a.name
             FROM author a
QUERY;
        $statement = $this->connection->prepare($sql);
        $statement->execute();

         return $statement->fetchAll();
    }
}
