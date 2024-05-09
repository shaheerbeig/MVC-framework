<?php
namespace app\model;
use app\core\Model;

class Contact extends Model{
    public string $Subject = '';
    public string $Email = '';
    public string $Body = '';

    public function rules():array{
        return [
            'Subject' => [self::RULE_REQUIRED],
            'Email' => [self::RULE_REQUIRED],
            'Body' => [self::RULE_REQUIRED],
        ];
    }
}