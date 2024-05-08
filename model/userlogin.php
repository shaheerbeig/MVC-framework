<?php
namespace app\model;
use app\core\Application;
use app\core\Model;

class userlogin extends Model{
    public  string $email='';
    public  string $password='';
    public function rules():array{
        return [
            'email' => [self::RULE_REQUIRED,self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED],
        ];
    }

    public function login(){
        $user = users::findUser(['email' => $this->email]);
        if(is_null($user->email)){
            $this->handleerrors('email',self::RULE_EMAIL_MISMATCH);
            return false;
        }
        elseif(!password_verify($this->password,$user->password)){
            $this->handleerrors('password',self::RULE_PASSWORD_MISMATCH);
            return false;
        }
        //if the password and the email matched then:
        Application::$app->login($user);
        return true;
    }
};