<?php
/**
 * Created by PhpStorm.
 * User: Stephe
 * Date: 23/03/17
 * Time: 10:19
 */

function getTasksIndex()
{
    $pdo = connectDB();
    if($pdo) {
        $stmt = $pdo->prepare('SELECT tasks.id AS taskId, tasks.description AS taskDescription, tasks.is_done AS taskIsDone 
                                FROM tasks
                                LEFT JOIN task_user ON tasks.id = task_user.task_id
                                LEFT JOIN users ON task_user.user_id = users.id
                                WHERE users.id = :userId
                                ORDER BY description ASC
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