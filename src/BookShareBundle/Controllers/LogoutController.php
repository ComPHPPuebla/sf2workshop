<?php
namespace BookShareBundle\Controllers;

use Framework\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LogoutController
{
    use Controller;

    protected $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function logoutAction()
    {
        $this->session->clear();
        $this->session->invalidate();

        return new RedirectResponse('/index.php/login');
    }
}
