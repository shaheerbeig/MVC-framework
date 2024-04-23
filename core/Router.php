<?php

namespace app\core;

class Router{
    //this array will store the callback function against the requested url/paths.
    protected array $storeRoutes = [];

    public function get($request,$path , $callback){
        $this->storeRoutes[$request][$path] = $callback;
    }

};