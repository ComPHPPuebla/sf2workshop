<?php
/**
 * @return PDO
 */
function db_connect()
{
    try {

        $connection = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    } catch (PDOException $exception) {

        if (APP_SHOW_ERRORS) {
            echo "<pre>$exception</pre>";
        }
        error_log((string) $exception);

    } finally {

        return $connection;
    }
}

/**
 * @param  PDO    $conn
 * @param  string $sql
 * @param  array  $parameters
 * @return array
 */
function query(PDO $conn, $sql, array $parameters = [])
{
    $statement = $conn->prepare($sql);
    $statement->execute($parameters);

    return $statement->rowCount();
}

/**
 * @param  PDO    $conn
 * @param  string $sql
 * @param  array  $parameters
 * @return array
 */
function query_fetch_all(PDO $conn, $sql, array $parameters = [])
{
    $statement = $conn->prepare($sql);
    $statement->execute($parameters);

    return $statement->fetchAll();
}

/**
 * @param  PDO    $conn
 * @param  string $sql
 * @param  array  $parameters
 * @return array
 */
function query_fetch_one(PDO $conn, $sql, array $parameters = [])
{
    $statement = $conn->prepare($sql);
    $statement->execute($parameters);

    return $statement->fetch();
}
