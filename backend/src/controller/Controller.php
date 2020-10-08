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
use MyApp\Config\Session;
use MyApp\Constraint\Validation;

abstract class Controller{
    protected $proSanteModel;
    protected $prosSanteModel;
    protected $commentModel;
    protected $commentsModel;
    protected $userModel;
    protected $usersModel;
    protected $favoritesModel;
    protected $view;
    protected $session;
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
        $this->session = new Session($_SESSION);
        $this->validation = new Validation();
    }

    protected function checkLoggedIn(){
        if(!($this->session->get('role'))){
            $this->session->set('need_login', 'Vous devez être vous connectez pour accéder à cette page');
            header('Location: index.php?route=login');
        }
        else{
            return true;
        }
    }

    protected function checkAdmin(){
        if(!($this->session->get('role') === 'admin')){
            $this->session->set('need_admin', 'Vous devez être administrateur pour accéder à cette page');
            header('Location: index.php');
        }
        else{
            return true;
        }
    }
}