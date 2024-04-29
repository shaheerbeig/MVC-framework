<?php

namespace app\core;

class Sessions{
    public const FLASH = 'FLASH_MESSAGE';
    //these are the type of flash messages
    public const ERROR = 'ERROR';
    public const WARNING = 'WARNING';
    public const INFO = 'INFO';
    public const SUCCESS = 'SUCCESS';

    public function __construct(){
        session_start();
    }

    public function createFlash($key,$message,$type){
        if(isset($_SESSION[self::FLASH][$key])){
            unset($_SESSION[self::FLASH][$key]);
        }
        $_SESSION[self::FLASH][$key] = ['message' => $message , 'type' => $type];
    }

    public function getFlash($key){
        if(isset($_SESSION[self::FLASH][$key])){
            $message = $_SESSION[self::FLASH][$key];
            unset($_SESSION[self::FLASH][$key]);
            return $message['message'];
        }
        return null;
    }
};