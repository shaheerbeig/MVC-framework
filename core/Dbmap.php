<?php
namespace app\core;
use app\core\Model;

abstract class Dbmap extends Model{

    //this method will just return the table name.
    abstract public function tableName(); 
    abstract public function getattribute():array ;


    public function saveUser(){
        $tablename = $this->tableName();
        $userAttributes = $this->getattribute();
        
        $bind = array_map(fn($attribute)=>":"."$attribute",$userAttributes);
        $query = ("INSERT INTO $tablename (".implode(',',$userAttributes).") VALUES (".implode(',',$bind).")");
        $stmt = Application::$app->db->pdo->prepare($query);

        foreach($userAttributes as $attribute){
            $stmt->bindValue($attribute,$this->{$attribute});
        }
        $stmt->execute();
    }
};