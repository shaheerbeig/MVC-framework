<?php
namespace app\core;
use PDO;
use app\migrations;
class Database
{
    public PDO $pdo ;
    public function __construct($configuration){
        $dbname = $configuration['dbname'];
        $host = $configuration['host'];
        $port = $configuration['port'];
        $user = $configuration['user'];
        $password = $configuration['password'];

        $this->pdo = new PDO('mysql:host=' . $host . ';port=' . $port . ';dbname=' . $dbname , $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }  
    
    public function apply(){
        $this->createTable();
        $migration = $this->checkColumn();

        //this will check the files in the migrations folder in the root directory
        $containFiles = scandir(Application::$rootPath . '/migrations');
        $nonmigratedFiles = array_diff($containFiles,$migration);
        $migrationarray = [];

        foreach($nonmigratedFiles as $applymigration){
            if($applymigration === '.' || $applymigration === '..'){
                continue;
            }
            require_once Application::$rootPath . '/migrations/' . $applymigration;
            $filepath = explode('.',$applymigration)[0];

            $migrateInstance = new $filepath();
            $migrateInstance->upMigration();

            $migrationarray[] = $applymigration;
        }
        if(!empty($migrationarray)){

            $this->savemigrations($migrationarray);
        }
        else{
            echo "All migrations have been applied";
        }
    }

    //this function is responsible for creating a migration .
    public function createTable(){
        $this->pdo->exec('CREATE TABLE IF NOT EXISTS db_connection(
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration varchar(250),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)');
    }
    public function checkColumn(){
        $stmt = $this->pdo->prepare('SELECT migration FROM db_connection');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function savemigrations(array $migration){
        foreach($migration as $migrate){
            $query = 'INSERT INTO db_connection (migration) VALUES (?)';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$migrate]);
        }
    }
};