<?php
namespace MyApp\Constraint;

class UserValidation extends Validation{

    private $errors = [];
    private $constraint;

    public function __construct(){
        $this->constraint = new Constraint();
    }

    public function check($post){
        foreach($post as $key => $value){
            $this->checkField($key, $value);
        }
        return $this->errors;
    }

    private function checkField($name, $value){
        if($name === 'pseudo'){
            $error = $this->checkPseudo($name, $value);
            $this->addError($name, $error);
        }
        if($name === 'email'){
            $error = $this->checkEmail($name, $value);
            $this->addError($name, $error);
        }
        elseif($name === 'password'){
            $error = $this->checkPassword($name, $value);
            $this->addError($name, $error);
        }
        elseif($name === 'passwordOne'){
            $error = $this->checkPassword($name, $value);
            $this->addError($name, $error);
        }
        elseif($name === 'passwordTwo'){
            $error = $this->checkPassword($name, $value);
            $this->addError($name, $error);
        }
    }

    private function addError($name, $error){
        if($error){
            $this->errors += [
                $name => $error
            ];
        }
    }

    private function checkPseudo($name, $value){
        if($this->constraint->notEmpty($name, $value)){
            return $this->constraint->notEmpty('pseudo', $value);
        }
        if($this->constraint->minLength($name, $value, 5)){
            return $this->constraint->minLength('pseudo', $value, 5);
        }
        if($this->constraint->maxLength($name, $value, 30)){
            return $this->constraint->maxLength('pseudo', $value, 30);
        }
        if($this->constraint->checkIfScript($name, $value)){
            return $this->constraint->checkIfScript('pseudo', $value);
        }
    }

    private function checkEmail($name, $value){
        if($this->constraint->notEmpty($name, $value)){
            return $this->constraint->notEmpty('email', $value);
        }
        if($this->constraint->minLength($name, $value, 2)){
            return $this->constraint->minLength('email', $value, 2);
        }
        if($this->constraint->maxLength($name, $value, 100)){
            return $this->constraint->maxLength('email', $value, 100);
        }
        if($this->constraint->isEmail($name, $value)){
            return $this->constraint->isEmail('email', $value);
        }
        if($this->constraint->checkIfScript($name, $value)){
            return $this->constraint->checkIfScript('email', $value);
        }
    }

    private function checkPassword($name, $value){
        if($this->constraint->notEmpty($name, $value)){
            return $this->constraint->notEmpty('mot de passe', $value);
        }
        if($this->constraint->minLength($name, $value, 4)){
            return $this->constraint->minLength('mot de passe', $value, 4);
        }
        if($this->constraint->checkIfScript($name, $value)){
            return $this->constraint->checkIfScript('mot de passe', $value);
        }
    }
}
