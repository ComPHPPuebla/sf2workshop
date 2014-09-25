<?php
namespace SecurityBundle\Controllers;

use Framework\Controller;
use SecurityBundle\Forms\Types\LoginFormType;
use Symfony\Component\Form\FormFactory;
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

    /** @var FormFactory */
    protected $formFactory;

    /**
     * @param AllUsers    $allUsers
     * @param Session     $session
     * @param FormFactory $formFactory
     */
    public function __construct(AllUsers $allUsers, Session $session, FormFactory $formFactory)
    {
        $this->allUsers = $allUsers;
        $this->session = $session;
        $this->formFactory = $formFactory;
    }

    /**
     * @param Request $request
     */
    public function authenticateAction(Request $request)
    {
        $form = $this->formFactory->create(new LoginFormType());
        $form->handleRequest($request);

        $invalidCredentialsMessage = 'The username or password you entered were incorrect.';
        if ($form->isValid()) {
            $credentials = $form->getData();

            $user = $this->allUsers->ofUsername($credentials['username']);

            if (!$user || !password_verify($credentials['password'], $user['password'])) {
                return new JsonResponse(['error' => $invalidCredentialsMessage]);
            }

            $user['password'] = null;
            $this->session->set(APP_SESSION_NAMESPACE, ['user' => $user]);

            return new JsonResponse(['success' => true]);
        }

        return new JsonResponse(['error' => $invalidCredentialsMessage]);
    }
}
