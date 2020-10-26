<?php
namespace MyApp\Controller;

use MyApp\Model\ProSanteModel;
use MyApp\Model\ProsSanteModel;
use MyApp\Model\CommentModel;
use MyApp\Model\CommentsModel;
use MyApp\Model\UserModel;
use MyApp\Model\UsersModel;
use MyApp\Model\FavoritesModel;
use MyApp\View\View;
use MyApp\Config\Authentification;
use MyApp\Constraint\Validation;

abstract class Controller extends Authentification{
    protected $proSanteModel;
    protected $prosSanteModel;
    protected $commentModel;
    protected $commentsModel;
    protected $userModel;
    protected $usersModel;
    protected $favoritesModel;
    protected $view;
    protected $authentification;
    protected $validation;

    public function __construct(){
        $this->proSanteModel = new proSanteModel();
        $this->prosSanteModel = new ProsSanteModel();
        $this->commentModel = new CommentModel();
        $this->commentsModel = new CommentsModel();
        $this->userModel = new UserModel();
        $this->usersModel = new UsersModel();
        $this->favoritesModel = new FavoritesModel();
        $this->view = new View();
        $this->authentification = new Authentification();
        $this->validation = new Validation();
    }

    public function lookAuth($user){
        $data = $this->authentification->createTokenAuthentification($user);
        return $data;
    }

    public function checkAuth(){
        $data = $this->authentification->checkAuthentification();
        return $data;
    }

    public function checkAuthAdmin(){
        $data = $this->authentification->checkAuthAdmin();
        return $data;
    }

    public function checkIfScript($string){
        $content_array = explode(" ", $string);
        $output1 = '';
        foreach($content_array as $content1){
            if(substr($content1, 0, 8) == "<script>"){
                return true;
            } else {
                return false;
            }
        }
    }   
}