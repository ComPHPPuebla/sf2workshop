<?php
namespace SecurityBundle\Controllers;

use Framework\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Security\Persistence\Pdo\AllUsers;
use PDOException;

class AuthenticateController
{
    use Controller;

    /** @var AllUsers */
    protected $allUsers;

    /** @var Session */
    protected $session;

    /**
     * @param AllUsers $allUsers
     * @param Session  $session
     */
    public function __construct(AllUsers $allUsers, Session $session)
    {
        $this->allUsers = $allUsers;
        $this->session = $session;
    }

    /**
     * @param Request $request
     */
    public function authenticateAction(Request $request)
    {
        if (!$request->request->has('username') || !$request->request->has('password')) {

            return new JsonResponse(['error' => 'Enter your username and password.']);
        }

        $username = $request->request->filter('username', null, false, FILTER_SANITIZE_STRING);
        $password = $request->request->filter('password', null, false, FILTER_SANITIZE_STRING);

        try {

            $user = $this->allUsers->ofUsername($username);

            $invalidCredentialsMessage = 'The username or password you entered were incorrect.';
            if (!$user) {

                return new JsonResponse(['error' => $invalidCredentialsMessage]);
            }

            if (!password_verify($password, $user['password'])) {

                return new JsonResponse(['error' => $invalidCredentialsMessage]);
            }

            $user['password'] = null;

            $this->session->set(APP_SESSION_NAMESPACE, ['user' => $user]);

            return new JsonResponse(['success' => true]);

        } catch (PDOException $e) {

            error_log("PDO Exception: \n{$e}\n");
            $response = new Response();
            $response->setStatusCode(500);

            return $response;
        }
    }
}
