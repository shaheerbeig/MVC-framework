<?php

namespace app\core;

class Request{
    public function getPath($requestedURL){
        $path = explode("?",$requestedURL)[0];
        return $path;
    }  
};