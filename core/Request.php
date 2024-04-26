<?php

namespace app\core;

class Request{

    //function will extract the path from the uri
    public function getPath(){
        $requestedURL = $_SERVER['REQUEST_URI'];
        $path = explode("?",$requestedURL)[0];
        return $path;
    }

    //returns what the request type
    public function getmethod(){
        return strtolower($_SERVER['REQUEST_METHOD']);
    }


    public function getBody(){
        $body = [];
        
        if($this->getmethod()=== 'get'){
            foreach($_GET as $key => $value){
                $body[$key] = filter_input(INPUT_GET,$key,FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if($this->getmethod()  === 'post'){
            foreach($_POST as $key => $value){
                $body[$key] = filter_input(INPUT_POST,$key,FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }
};