<?php
namespace app\core\form;
use app\core\Model;

class Form{
    public static function beginform($action,$method):self{
        echo sprintf('<form action="%s" method="%s">',$action,$method);
        return new Form();
    }

    public static function endform(){
        echo '</form>';
    }

    public function field(Model $model , $attribute){
        return new Field($model,$attribute);
    }
};