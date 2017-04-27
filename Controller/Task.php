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
        $_SESSION['tasks'] = $this->modelTask->getTasksIndex($_SESSION['user']['id']);
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
        $description = $this->modelTask->checkDescription($_POST['description']);
        $is_done = isset($_POST['is_done']) ? 1 : 0;
        if($this->modelTask->updateTask($description, $_POST['id'], $is_done)){
            header('Location: http://homestead.app/pwcs/todolist/index.php?r=task&a=index');
            exit;
        } else {
            echo 'Il y a une erreur dans la connexion avec la base de données';
        }
    }

    public function create()
    {
        $this->checkLogin();
        if($this->modelTask->createTask($_POST['description'], $_SESSION['user']['id'])){
            header('Location: http://homestead.app/pwcs/todolist/index.php?r=task&a=index');
            exit;
        } else {
            echo 'Il y a une erreur dans la connexion avec la base de données';
        }
    }

    public function postDelete()
    {
        $this->checkLogin();
        if($this->modelTask->deleteTask($_POST['id'])){
            header('Location: http://homestead.app/pwcs/todolist/index.php?r=task&a=index');
            exit;
        } else {
            echo 'Il y a une erreur dans la connexion avec la base de données';
        }
    }
}


