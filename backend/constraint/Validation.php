<?php
namespace constraint;

class Validation{
    public function validate($data, $name){
        if($name === 'Comment'){
            $commentValidation = new CommentValidation();
            $errors = $commentValidation->check($data);
        }
        elseif($name === 'User'){
            $userValidation = new UserValidation();
            $errors = $userValidation->check($data);
        }
        return $errors;
    }
}