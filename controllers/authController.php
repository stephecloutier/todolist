<?php
/**
 * Created by PhpStorm.
 * User: Stephe
 * Date: 23/03/17
 * Time: 10:07
 */
function getLogin ()
{
    return ['view' => 'views/auth.php'];
}

function getLogout ()
{
    if(ini_get("session.use_cookies")){
        $params = session_get_cookie_params();

        setcookie(session_name(), '', time(1),
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
        session_destroy();
    }

    header('Location: http://homestead.app/pwcs/todolist/index.php');
}

function postLogin ()
{
    $_SESSION['email'] = $_POST['email'];
    include 'models/authModel.php';
    if(connectUser()){
        header('Location: http://homestead.app/pwcs/todolist/index.php?r=task&a=index');
    } else {
        echo 'Il y a une erreur dans vos identifiants';
    }

}