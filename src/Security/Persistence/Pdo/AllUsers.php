<?php
namespace Security\Persistence\Pdo;

use Security\AllUsers as AllUsersInterface;
use PDO;

class AllUsers implements AllUsersInterface
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
     * @see \Security\AllUsers::ofUsername()
     */
    public function ofUsername($username)
    {
        $statement = $this->connection->prepare('SELECT * FROM user u WHERE u.username = ?');
        $statement->execute([$username]);

        return $statement->fetch();
    }
}
