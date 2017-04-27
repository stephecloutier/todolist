<?php

namespace Model;

class Task extends Model {

    public function getTasksIndex($userId)
    {
        $pdo = $this->connectDB();
        if($pdo) {
            $stmt = $pdo->prepare('SELECT tasks.id AS taskId, tasks.description AS taskDescription, tasks.is_done AS taskIsDone 
                                FROM tasks
                                LEFT JOIN task_user ON tasks.id = task_user.task_id
                                LEFT JOIN users ON task_user.user_id = users.id
                                WHERE users.id = :userId
                                ORDER BY tasks.id ASC;
                              ');
            $stmt->bindValue(':userId', $userId);
            try {
                $stmt->execute();
                $tasks = $stmt->fetchAll();
            } catch(\PDOException $e) {
                die('Connection failed:' . $e->getMessage());
            }
            return $tasks;
        }
    }

    public function checkDescription($description)
    {
        $description = trim($description);
        if(strlen($description) > 0) {
            return $description;
        }
        return false;
    }

    public function updateTask($description, $id, $isDone)
    {
        $pdo = $this->connectDB();

        if($pdo) {
            if($description !== false) {
                $stmt = $pdo->prepare('UPDATE tasks
                                SET description = :description, is_done = :is_done
                                WHERE id = :id;
                              ');
                $stmt->bindValue(':description', $description);
                $stmt->bindValue(':is_done', $isDone);
                $stmt->bindValue(':id', $id);
            } else {
                $stmt = $pdo->prepare('UPDATE tasks
                                SET is_done = :is_done
                                WHERE id = :id;
                              ');
                $stmt->bindValue(':is_done', $isDone);
                $stmt->bindValue(':id', $id);
            }

            try {
                $stmt->execute();
            } catch(\PDOException $e) {
                die('Connection failed:' . $e->getMessage());
            }
            return true;

        }
    }
    public function createTask($description, $userId)
    {
        $pdo = $this->connectDB();
        if($pdo) {
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare('INSERT INTO tasks(`description`) VALUES(:description);');
            $stmt->bindValue(':description', $description);
            try {
                $stmt->execute();

                $stmt = $pdo->prepare('INSERT INTO task_user(`task_id`, `user_id`) VALUES(:task_id, :user_id);');
                $taskId =  $pdo->lastInsertId();
                $stmt->bindValue(':task_id', $taskId);

                $stmt->bindValue(':user_id', $userId);
                $stmt->execute();
            } catch(\PDOException $e) {
                die('Connection failed:' . $e->getMessage());
            }
            return true;
        }
    }

    public function deleteTask($taskId)
    {
        $pdo = $this->connectDB();
        if($pdo) {
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = :id');
            $stmt->bindValue(':id', $taskId);
            try {
                $stmt->execute();

                $stmt = $pdo->prepare('DELETE FROM task_user WHERE task_id = :id');
                $stmt->bindValue(':id', $taskId);
                $stmt->execute();

            } catch(\PDOException $e) {
                die('Connection failed:' . $e->getMessage());
            }
            return true;
        }
    }
}

