<?php
namespace app\core;

abstract class Model{
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;
    public const STATUS_DELETED = 2;
    //THESE ARE JUST RULES DEFINED AGAINST WHICH DATA WILL BE VALIDATED.
    public const RULE_REQUIRED = 'required';
    public const RULE_MIN = 'min';
    public const RULE_MATCH = 'match';
    public const RULE_EMAIL = 'email';
    public const RULE_DIFF_EMAIL = "unique";
    public const RULE_EMAIL_MISMATCH = "email mismatch";
    public const RULE_PASSWORD_MISMATCH = "password mismatch";

    public array $errors = [];

    public array $errormsg = [self::RULE_REQUIRED => 'This filed is mandatory to be filled.',
    self::RULE_EMAIL => 'Email Address required.',
    self::RULE_MIN => 'Minimum length of the Password should be 8.',
    self::RULE_MATCH => 'This filed must be same as Password.',
    self::RULE_DIFF_EMAIL => 'Email already Used before. Use another email.',
    self::RULE_EMAIL_MISMATCH => 'User with this Email Address donot exists.',
    self::RULE_PASSWORD_MISMATCH => 'Password Donot Match.'];

    //this function will just populate the class variables with the user provided data.
    public function LoadData($data){
        foreach($data as $key => $value){
            if(property_exists($this,$key)){
                $this->{$key} = $value;
            }
        }
    }
    abstract public function rules():array ;

    public function validateData(){
        foreach($this->rules() as $key => $value){  
            //here we are extracting the data .
            //here data is what the user has entered
            $data = $this->{$key};
            //using a for each nested loop because some attributes can have more than 1 rule associated with it
            foreach($value as $rule){
                $actualrule = $rule;

                if(!is_string($actualrule)){
                    $actualrule = $rule[0];
                }

                //possible errors
                if($actualrule === self::RULE_REQUIRED && !$data){
                    $this->handleerrors($key,self::RULE_REQUIRED);
                }
                if($actualrule === self::RULE_EMAIL && !filter_var($data,FILTER_VALIDATE_EMAIL)){
                    $this->handleerrors($key,self::RULE_EMAIL);
                }
                if($actualrule === self::RULE_MIN &&  strlen($data) < 8){
                    $this->handleerrors($key,self::RULE_MIN);
                }
                if ($actualrule === self::RULE_MATCH) {
                    $field_to_match = $rule['match'];
                    if ($data !== $this->{$field_to_match}) { 
                        $this->handleerrors($key, self::RULE_MATCH);
                    }
                }
                if($actualrule === self::RULE_DIFF_EMAIL){
                    $classname = $rule['class'];
                    $tablename = $classname::tableName();
                    $attr = $rule['attribute'] ?? $key;

                    $query = "SELECT * FROM $tablename WHERE $attr = :attr";
                    $stmt = Application::$app->db->pdo->prepare($query);
                    $stmt->bindValue(":attr",$data);
                    $stmt->execute();
                    $userrecord = $stmt->fetch();
                    if($userrecord){
                        $this->handleerrors($key,self::RULE_DIFF_EMAIL);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    public function handleerrors($attribute , $error){
        $this->errors[$attribute] = $this->getErrorMsg($error);
    }

    public function getErrorMsg($error){
        foreach($this->errormsg as $key => $value){
            if($key === $error){
                return $this->errormsg[$key];
            }
        }
    }

    public function hasError($attribute){
        return $this->errors[$attribute] ?? false;
    }

    public function attributeError($attribute){
        return $this->errors[$attribute] ?? false;
    }
};  