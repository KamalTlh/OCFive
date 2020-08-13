<?php
namespace controller;
use model\ProSanteModel;
use model\ProsSanteModel;
use view\View;
use config\Session;
use constraint\Validation;

abstract class Controller{
    protected $proSanteModel;
    protected $prosSanteModel;
    protected $view;
    protected $session;
    protected $validation;

    public function __construct(){
        $this->proSanteModel = new proSanteModel();
        $this->prosSanteModel = new ProsSanteModel();
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