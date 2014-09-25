<?php
namespace BookShare\Persistence\Pdo;

use BookShare\AllReaders as AllReadersInterface;
use BookShare\Reader;
use PDO;

class AllReaders implements AllReadersInterface
{
    /** @type PDO */
    protected $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function ofUsername($username)
    {
        $sql = 'SELECT * FROM user WHERE username = ?';
        $statement = $this->connection->prepare($sql);
        $statement->execute([$username]);

        $row = $statement->fetch();

        return new Reader($row['username'], $row['points']);
    }

    public function update(Reader $reader)
    {
        $sql = 'UPDATE user SET points = ? WHERE username = ?';
        $statement = $this->connection->prepare($sql);
        $statement->execute([$reader->points(), $reader->username()]);
    }
}
