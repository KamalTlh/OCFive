<?php
namespace MyApp\constraint;

class Constraint{

    public function notEmpty($name, $value){
        if(empty($value)){
            return 'Le champ saisi est vide';
        }
    }

    public function minLength($name, $value, $minSize){
        if(strlen($value) < $minSize){
            return 'Le champ saisi doit contenir au moins '.$minSize.' caractères';
        }
    }

    public function maxLength($name, $value, $maxSize){
        if(strlen($value) > $maxSize){
            return 'Le champ saisi doit contenir moins de '.$maxSize.' caractères';
        }
    }

    public function isEmail($name, $value){
        if ( !(preg_match ( " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ " , $value )) ){
            return 'Merci de saisir une adresse email valide';
        }
    }

    public function checkIfScript($name, $value){
        $content_array = explode(" ", $value);
        $output1 = '';
        foreach($content_array as $content1){
            if(substr($content1, 0, 8) == "<script>"){
                return 'Champ saisi invalide';
            }
        }
    }   
}