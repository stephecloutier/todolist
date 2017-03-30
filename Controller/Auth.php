<?php

namespace Controller;

use \Model\Auth as AuthModel;

class Auth {
    public function getLogin ()
    {
        return ['view' => 'views/auth.php'];
    }

    public function getLogout ()
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
        exit;
    }

    public function postLogin ()
    {
        $_SESSION['email'] = $_POST['email'];
        $authModel = new AuthModel();
        if($authModel->connectUser()){
            header('Location: http://homestead.app/pwcs/todolist/index.php?r=task&a=index');
            exit;
        } else {
            echo 'Il y a une erreur dans vos identifiants';
        }

    }
}