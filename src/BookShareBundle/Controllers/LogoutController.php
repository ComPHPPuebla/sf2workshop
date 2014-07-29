<?php
namespace BookShareBundle\Controllers;

use Framework\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LogoutController
{
    use Controller;

    public function logoutAction()
    {
        $session = new Session();
        $session->start();
        $session->clear();
        $session->invalidate();

        return new RedirectResponse('/index.php/login');
    }
}
