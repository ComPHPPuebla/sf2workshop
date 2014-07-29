<?php
namespace BookShareBundle\Controllers;

use Framework\Controller;

class LoginController
{
    use Controller;

    public function loginAction()
    {
        return $this->renderResponse('login.phtml');
    }
}
