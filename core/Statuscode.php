<?php
namespace app\core;
class Statuscode{
    public function setresposeCode(int $code){
        http_response_code($code);
    }
}