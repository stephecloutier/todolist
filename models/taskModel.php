<?php
/**
 * Created by PhpStorm.
 * User: Stephe
 * Date: 23/03/17
 * Time: 10:19
 */

function checkLogin()
{
    if(!isset($_SESSION['user'])) {
        header('Location: http://homestead.app/pwcs/todolist/index.php?r=task&a=index' );
    }
}

function getTasksIndex()
{
    $pdo = connectDB();
    if($pdo) {
        $stmt = $pdo->prepare('SELECT tasks.id AS taskId, tasks.description AS taskDescription, tasks.is_done AS taskIsDone 
                                FROM tasks
                                LEFT JOIN task_user ON tasks.id = task_user.task_id
                                LEFT JOIN users ON task_user.user_id = users.id
                                WHERE users.id = :userId
                                ORDER BY description ASC;
                              ');
        $stmt->bindParam(':userId', $_SESSION['user']['id']);
        try {
            $stmt->execute();
            $tasks = $stmt->fetchAll();
        } catch(PDOException $e) {
            die('Connection failed:' . $e->getMessage());
        }
        return $tasks;
    }
}

function updateTask()
{
    $pdo = connectDB();
    if($pdo) {
        $stmt = $pdo->prepare('UPDATE tasks
                                SET description = :description
                                WHERE id = :id;
                              ');
        $stmt->bindParam(':description', $_POST['description']);
        //$stmt->bindParam(':is_done', $_POST['is_done']);
        $stmt->bindParam(':id', $_POST['id']);
        try {
            $stmt->execute();
        } catch(PDOException $e) {
            die('Connection failed:' . $e->getMessage());
        }
        return true;
    }
}
function createTask()
{
    $pdo = connectDB();
    if($pdo) {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare('INSERT INTO tasks(`description`) VALUES(:description);');
        $stmt->bindParam(':description', $_POST['description']);
        try {
            $stmt->execute();

            $stmt = $pdo->prepare('INSERT INTO task_user(`task_id`, `user_id`) VALUES(:task_id, :user_id);');
            $taskId =  $pdo->lastInsertId();
            $stmt->bindParam(':task_id', $taskId);

            $stmt->bindParam(':user_id', $_SESSION['user']['id']);
            $stmt->execute();
        } catch(PDOException $e) {
            die('Connection failed:' . $e->getMessage());
        }
        return true;
    }
}

function deleteTask()
{
    $pdo = connectDB();
    if($pdo) {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = :id');
        $stmt->bindParam(':id', $_POST['id']);
        try {
            $stmt->execute();

            $taskId = $_POST['id'];
            $stmt = $pdo->prepare('DELETE FROM task_user WHERE task_id = :id');
            $stmt->bindParam(':id', $taskId);
            $stmt->execute();

        } catch(PDOException $e) {
            die('Connection failed:' . $e->getMessage());
        }
        return true;
    }
}
