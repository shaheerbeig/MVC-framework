<?php
use app\core\Application;
class migration01{
    public function upMigration(){
        $query = ('CREATE TABLE IF NOT EXISTS users (
             id INT AUTO_INCREMENT PRIMARY KEY,
             email varchar(100),
             firstname varchar(50),
             lastname varchar(50),
             status TINYINT NOT NULL DEFAULT 0,
             created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
        )');
        $db = Application::$app->db;
        $db->pdo->exec($query);
    }

    public function downMigration(){
        $query = ('DROP TABLE db_connection');
        Application::$app->db->pdo->exec($query);
    }
};  