<?php
function is_user_logged()
{
    session_start();
    if (!isset($_SESSION[APP_SESSION_NAMESPACE]['user'])) {
        header('Location: login.php');
        exit();
    }
}

function logout()
{
    session_start();
    session_destroy();
    unset($_SESSION);
}

function get_user_information($info)
{
    return $_SESSION[APP_SESSION_NAMESPACE]['user'][$info];
}
