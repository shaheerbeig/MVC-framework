<?php
namespace app\model;
use app\core\Application;
use app\core\Dbmap;

class users extends Dbmap{
    public string $firstname ='';
    public  string $lastname='';
    public  string $email='';
    public  string $password='';
    public string $confirmpassword='';
    public int $status = self::STATUS_INACTIVE;

    public function rules():array{
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED,self::RULE_EMAIL,[self::RULE_DIFF_EMAIL , 'class' => self::class]],
            'password' => [self::RULE_REQUIRED,[self::RULE_MIN , 'min' => 8]],
            'confirmpassword' => [self::RULE_REQUIRED,[self::RULE_MATCH , 'match' => 'password' , 'attribute' => 'email']],
        ];
    }
    public function saveUser(){
        //we will encrypt the password that will be stored in the database
        $this->status = self::STATUS_INACTIVE;
        //for security purpose we always encrypt the user's password
        $this->password = password_hash($this->password,PASSWORD_DEFAULT);
        parent::saveUser();
        return true;
    }

    public function tableName(){
        return 'users';
    }

    public function getattribute(): array{
        $attributes = [];
        foreach($this->rules() as $key => $value){
            if($key !== 'confirmpassword'){
                $attributes[] = $key;
            }
        }
        return $attributes;
    }
    public static function findUser($array){
        $class = new self();
        $tablename = $class->tableName();
        $key = array_keys($array)[0];
        $query = ("SELECT * FROM $tablename where $key = :find");
        $stmt = Application::$app->db->pdo->prepare($query);
        $value = $array[$key];
        $stmt->bindValue(":find",$value);
        $stmt->execute();
        $userObject = $stmt->fetchObject(self::class);
        return $userObject;
    }

    public static function getIdentifier():string{
        return 'id';
    }

    public function displayName(){
        echo $this->firstname ;
    }
};