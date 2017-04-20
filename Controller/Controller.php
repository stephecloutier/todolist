<?php
/**
 * Created by PhpStorm.
 * User: Stephe
 * Date: 20/04/17
 * Time: 09:23
 */

namespace Controller;


class Controller
{

    protected function checkLogin()
    {
        if(!isset($_SESSION['user'])) {
            header('Location: http://homestead.app/pwcs/todolist/index.php?r=task&a=index' );
            exit;
        }
    }
}