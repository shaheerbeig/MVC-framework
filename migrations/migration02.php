<?php
use app\core\Application;
class migration02{
    public function upMigration(){
        $query = ('ALTER TABLE users ADD COLUMN password varchar(150) NOT NULL');
        Application::$app->db->pdo->exec($query);
    }

    public function downMigration(){
        $query = ('ALTER TABLE users DROP COLUMN password');
        Application::$app->db->pdo->exec($query);
    }
};  