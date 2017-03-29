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
    session_destroy();
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