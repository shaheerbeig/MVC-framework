<?php
namespace app\core\form;
use app\core\Model;

class Field{
    public string $attribute;
    public Model $model;

    public function __construct(Model $model , $attribute){
        $this->model = $model;
        $this->attribute= $attribute;
    }

    public function data() {
        $errorClass = $this->model->hasError($this->attribute) ? ' is-invalid' : '';
        $errorMessage = $this->model->attributeError($this->attribute);
      
        return sprintf('
          <div class="mb-3">
            <label for="%s">%s</label>
            <input type="%s" name="%s" value="%s" class="form-control%s" id="%s">
            %s
          </div>
        ',
          $this->attribute,        
          ucfirst($this->attribute),
          $this->getType($this->attribute),
          $this->attribute,
          $this->model->{$this->attribute},
          $errorClass,
          $this->attribute,
          !empty($errorMessage) ? "<div class='invalid-feedback'>$errorMessage</div>" : ''
        );
      }

      public function getType($attribute){
        if($attribute === 'firstname'){
            return "text";
        }
        elseif($attribute === 'email'){
            return "email";
        }
        elseif($attribute === 'password' || $attribute === 'confirmpassword' ){
            return "password";
        }
      }
};