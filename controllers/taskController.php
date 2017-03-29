<?php
/**
 * Created by PhpStorm.
 * User: Stephe
 * Date: 23/03/17
 * Time: 10:06
 */

function index()
{
    include 'models/taskModel.php';
    $_SESSION['tasks'] = getTasksIndex();
    return ['view' => 'views/tasksIndex.php'];
}

function getUpdate()
{
    return ['view' => 'views/tasksGetUpdate.php'];
}

function postUpdate()
{
    include 'models/taskModel.php';
    if(updateTask()){
        header('Location: http://homestead.app/pwcs/todolist/index.php?r=task&a=index');
    } else {
        echo 'Il y a une erreur dans la connexion avec la base de données';
    }
}