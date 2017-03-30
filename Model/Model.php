<?php

namespace Model;

class Model {
    public function connectDB ()
    {
        $dsn = '';
        $db_config = ['username' => '', 'password' => ''];

        if(file_exists(INI_FILE)){
            $db_config = parse_ini_file(INI_FILE);
            $dsn = sprintf('%s:dbname=%s;host=%s', $db_config['driver'], $db_config['dbname'], $db_config['host']);
        }
        try {
            return new \PDO(
                $dsn,
                $db_config['username'],
                $db_config['password']
            );
        } catch(\PDOException $e) {
            die('Connection failed:' . $e->getMessage());
        }
    }
}


