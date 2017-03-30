<?php

namespace Controller;

use \Model\Task as ModelTask;

class Task {
    public function index()
    {
        $modelTask = new ModelTask();
        $modelTask->checkLogin();
        $_SESSION['tasks'] = $modelTask->getTasksIndex();
        return ['view' => 'views/tasksIndex.php'];
    }

    public function getUpdate()
    {
        $modelTask = new ModelTask();
        $modelTask->checkLogin();
        return ['view' => 'views/tasksGetUpdate.php'];
    }

    public function postUpdate()
    {
        $modelTask = new ModelTask();
        $modelTask->checkLogin();
        if($modelTask->updateTask()){
            header('Location: http://homestead.app/pwcs/todolist/index.php?r=task&a=index');
            exit;
        } else {
            echo 'Il y a une erreur dans la connexion avec la base de données';
        }
    }

    public function create()
    {
        $modelTask = new ModelTask();
        $modelTask->checkLogin();
        if($modelTask->createTask()){
            header('Location: http://homestead.app/pwcs/todolist/index.php?r=task&a=index');
            exit;
        } else {
            echo 'Il y a une erreur dans la connexion avec la base de données';
        }
    }

    public function postDelete()
    {
        $modelTask = new ModelTask();
        $modelTask->checkLogin();
        if($modelTask->deleteTask()){
            header('Location: http://homestead.app/pwcs/todolist/index.php?r=task&a=index');
            exit;
        } else {
            echo 'Il y a une erreur dans la connexion avec la base de données';
        }
    }
}

