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
    return ['view' => 'views/taskGetUpdate.php'];
}

function postUpdate()
{
    include 'models/taskModel.php';
    return ['view' => 'views/tasksIndex.php'];
}