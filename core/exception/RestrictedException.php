<?php

namespace app\core\exception;

class RestrictedException extends \Exception{
    protected $message = 'You are not authorized to access this page';
    protected $code = 403;
};