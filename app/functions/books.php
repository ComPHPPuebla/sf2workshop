<?php
use BookShare\Persistence\Pdo\AllBooks;
use Symfony\Component\HttpFoundation\Request;
use Security\Persistence\Pdo\AllUsers;
use Symfony\Component\HttpFoundation\Session\Session;

function view_books()
{
    is_user_logged();

    $allBooks = new AllBooks(db_connect());

    return ['books' =>$allBooks->withBestRate()];
}

function view_book(Request $request)
{
    is_user_logged();

    $bookId = $request->attributes->getInt('bookId');
    $allBooks = new AllBooks(db_connect());

    return ['book' => $allBooks->ofBookId($bookId)];
}

function search_books(Request $request)
{
    is_user_logged();


    $searchType = $request->request->filter('search-type');
    $searchTerm = $request->request->filter('book-search');

    $allBooks = new AllBooks(db_connect());

    if ('title' === $searchType) {
        $books = $allBooks->ofTitleLike($searchTerm);
    } else {
        $books = $allBooks->ofAuthorNameLike($searchTerm);
    }

    return ['books' => $books];

}

function login()
{
    return [];
}

function logout()
{
    $session = new Session();
    $session->start();
    $session->clear();
    $session->invalidate();

    header('Location: /index.php/login');
    exit();
}

function authenticate(Request $request)
{
    if (!$request->request->has('username') || !$request->request->has('password')) {

        return ['error' => 'Enter your username and password.'];
    }

    $username = $request->request->filter('username', null, false, FILTER_SANITIZE_STRING);
    $password = $request->request->filter('password', null, false, FILTER_SANITIZE_STRING);

    try {

        $allUsers = new AllUsers(db_connect());
        $user = $allUsers->ofUsername($username);

        $invalidCredentialsMessage = 'The username or password you entered were incorrect.';
        if (!$user) {

            return ['error' => $invalidCredentialsMessage];
        }

        if (!password_verify($password, $user['password'])) {

            return ['error' => $invalidCredentialsMessage];
        }

        $user['password'] = null;

        $session = new Session();
        $session->start();
        $session->set(APP_SESSION_NAMESPACE, ['user' => $user]);

        return ['success' => true];

    } catch (PDOException $e) {

        error_log("PDO Exception: \n{$e}\n");
        http_response_code(500);
    }
}
