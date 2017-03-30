<?php

namespace Model;

class Auth extends Model {
    public function connectUser()
    {

        $pdo = $this->connectDB();
        $password = sha1($_POST['password']);
        if ($pdo) {
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email AND password = :password');
            $stmt->bindParam(':email', $_SESSION['email']);
            $stmt->bindParam(':password', $password);
            try {
                $stmt->execute();
                $user = $stmt->fetch();
            } catch (\PDOException $e) {
                die('Connection failed:' . $e->getMessage());
            }
            $_SESSION['user'] = $user;
            return true;
        }
    }
}


