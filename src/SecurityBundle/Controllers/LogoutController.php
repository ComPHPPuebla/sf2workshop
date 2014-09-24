<?php
namespace SecurityBundle\Controllers;

use Framework\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LogoutController
{
    use Controller;

    /** @var Session */
    protected $session;

    /**
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @return RedirectResponse
     */
    public function logoutAction()
    {
        $this->session->clear();
        $this->session->invalidate();

        return new RedirectResponse('/index.php/login');
    }
}
