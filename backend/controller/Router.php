<?php
namespace controller;

class Router{
    private $proSanteController;
    // private $commentController;
    private $errorController;
    // private $userController;
    
    public function __construct(){
        $this->proSanteController = new ProSanteController();
        // $this->commentController = new CommentController();
        $this->errorController = new ErrorController();
        // $this->userController = new UserController();
    }

    public function run(){
        try{
            if(isset($_GET)){
                if($_GET['route'] === 'medecins'){
                    $this->proSanteController->workers();
                }
                elseif(isset($_GET['commune']) || isset($_GET['civilite']) || isset($_GET['profession'])){
                    $this->proSanteController->workersByFilters($_GET);
                }
            }
            else{
                $this->errorController->errorPage();
            }
        }
        catch (Exception $e){
            $this->errorController->errorServer();      
        }
    }
}