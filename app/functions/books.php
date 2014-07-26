<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use BookShare\Persistence\Pdo\AllBooks;
use Security\Persistence\Pdo\AllUsers;

function view_books()
{
    is_user_logged();

    $allBooks = new AllBooks(db_connect());

    return render_response('view-books.phtml', ['books' => $allBooks->withBestRate()]);
}

function view_book(Request $request)
{
    is_user_logged();

    $bookId = $request->attributes->getInt('bookId');
    $allBooks = new AllBooks(db_connect());

    return render_response('view-book.phtml', ['book' => $allBooks->ofBookId($bookId)]);
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

    return render_response('search-books.phtml', ['books' => $books]);

}

function login()
{
    return render_response('login.phtml');
}

function logout()
{
    $session = new Session();
    $session->start();
    $session->clear();
    $session->invalidate();

    return new RedirectResponse('/index.php/login');
}

function authenticate(Request $request)
{
    if (!$request->request->has('username') || !$request->request->has('password')) {

        return render_response(
            'authenticate.phtml', ['error' => 'Enter your username and password.']
        );
    }

    $username = $request->request->filter('username', null, false, FILTER_SANITIZE_STRING);
    $password = $request->request->filter('password', null, false, FILTER_SANITIZE_STRING);

    try {

        $allUsers = new AllUsers(db_connect());
        $user = $allUsers->ofUsername($username);

        $invalidCredentialsMessage = 'The username or password you entered were incorrect.';
        if (!$user) {

            return render_response('authenticate.phtml', ['error' => $invalidCredentialsMessage]);
        }

        if (!password_verify($password, $user['password'])) {

            return render_response('authenticate.phtml', ['error' => $invalidCredentialsMessage]);
        }

        $user['password'] = null;

        $session = new Session();
        $session->start();
        $session->set(APP_SESSION_NAMESPACE, ['user' => $user]);

        return render_response('authenticate.phtml', ['success' => true]);

    } catch (PDOException $e) {

        error_log("PDO Exception: \n{$e}\n");
        http_response_code(500);
    }
}
