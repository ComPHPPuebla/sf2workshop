<?php
use Symfony\Component\HttpFoundation\Session\Session;

function is_user_logged()
{
    $session = new Session();
    $session->start();

    if (!$namespace = $session->has(APP_SESSION_NAMESPACE) || !isset($namespace['user'])) {
        header('Location: index.php/login');
        exit();
    }
}

function get_user_information($info)
{
    static $user;

    $session = new Session();

    if (!$user) {
        $namespace =$session->get(APP_SESSION_NAMESPACE);
        $user = $namespace['user'];
    }

    return $user[$info];
}
