<?php
if (empty($_POST['username']) || empty($_POST['password'])) {
    echo json_encode(['error' => 'Enter your username and password.']);

    return;
}

require 'config/constants.php';
require 'functions/db.php';

$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

try {

    $conn = db_connect();
    $sql = 'SELECT * FROM user u WHERE u.username = ?';
    $user = query_fetch_one($conn, $sql, [$username]);

    $invalidCredentialsMessage = 'The username or password you entered were incorrect.';
    if (!$user) {
        echo json_encode(['error' => $invalidCredentialsMessage]);

        return;
    }

    if (!password_verify($password, $user['password'])) {
        echo json_encode(['error' => $invalidCredentialsMessage]);

        return;
    }

    session_start();
    $user['password'] = null;
    $_SESSION[APP_SESSION_NAMESPACE] = ['user' => $user];

    echo json_encode(['success' => true]);

} catch (PDOException $e) {

    error_log("PDO Exception: \n{$e}\n");
    http_response_code(500);
}
