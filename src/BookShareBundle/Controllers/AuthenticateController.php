<?php
namespace BookShareBundle\Controllers;

use Framework\Controller;
use Symfony\Component\HttpFoundation\Request;
use Security\Persistence\Pdo\AllUsers;
use Symfony\Component\HttpFoundation\Session\Session;
use PDOException;

class AuthenticateController
{
    use Controller;

    protected $allUsers;
    protected $session;

    public function __construct(AllUsers $allUsers, Session $session)
    {
        $this->allUsers = $allUsers;
        $this->session = $session;
    }

    public function authenticateAction(Request $request)
    {
        if (!$request->request->has('username') || !$request->request->has('password')) {

            return $this->renderResponse(
                'authenticate.phtml', ['result' => ['error' => 'Enter your username and password.']]
            );
        }

        $username = $request->request->filter('username', null, false, FILTER_SANITIZE_STRING);
        $password = $request->request->filter('password', null, false, FILTER_SANITIZE_STRING);

        try {

            $user = $this->allUsers->ofUsername($username);

            $invalidCredentialsMessage = 'The username or password you entered were incorrect.';
            if (!$user) {

                return $this->renderResponse('authenticate.phtml', [
                    'result' => ['error' => $invalidCredentialsMessage]
                    ]);
            }

            if (!password_verify($password, $user['password'])) {

                return $this->renderResponse('authenticate.phtml', [
                    'result' => ['error' => $invalidCredentialsMessage]
                    ]);
            }

            $user['password'] = null;

            $this->session->set(APP_SESSION_NAMESPACE, ['user' => $user]);

            return $this->renderResponse('authenticate.phtml', ['result' => ['success' => true]]);

        } catch (PDOException $e) {

            error_log("PDO Exception: \n{$e}\n");
            http_response_code(500);
        }
    }
}