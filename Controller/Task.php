<?php

namespace Controller;

use \Model\Task as ModelTask;

class Task extends Controller {

    private $modelTask = null;

    public function __construct()
    {
        $this->modelTask = new ModelTask();
    }

    public function index()
    {
        $this->checkLogin();
        $_SESSION['tasks'] = $this->modelTask->getTasksIndex();
        return ['view' => 'views/tasksIndex.php'];
    }

    public function getUpdate()
    {
        $this->checkLogin();
        return ['view' => 'views/tasksGetUpdate.php'];
    }

    public function postUpdate()
    {
        $this->checkLogin();
        if($this->modelTask->updateTask()){
            header('Location: http://homestead.app/pwcs/todolist/index.php?r=task&a=index');
            exit;
        } else {
            echo 'Il y a une erreur dans la connexion avec la base de données';
        }
    }

    public function create()
    {
        $this->checkLogin();
        if($this->modelTask->createTask()){
            header('Location: http://homestead.app/pwcs/todolist/index.php?r=task&a=index');
            exit;
        } else {
            echo 'Il y a une erreur dans la connexion avec la base de données';
        }
    }

    public function postDelete()
    {
        $this->checkLogin();
        if($this->modelTask->deleteTask()){
            header('Location: http://homestead.app/pwcs/todolist/index.php?r=task&a=index');
            exit;
        } else {
            echo 'Il y a une erreur dans la connexion avec la base de données';
        }
    }
}


