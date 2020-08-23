<?php
namespace controller;

class Router{
    private $proSanteController;
    private $commentController;
    private $errorController;
    private $userController;
    
    public function __construct(){
        $this->proSanteController = new ProSanteController();
        $this->commentController = new CommentController();
        $this->errorController = new ErrorController();
        $this->userController = new UserController();
    }

    public function run(){
        try{
            $data = json_decode(file_get_contents("php://input"), true);
            if(isset($data) && !empty($data)){
                if( $data['route'] === 'login' ){
                    $this->userController->login($data['pseudo'], $data['password']);
                }
                elseif( $data['route'] === 'logout' ){
                    $this->userController->logout();
                }
                elseif( $data['route'] === 'signIn' ){
                    $this->userController->signIn($data['pseudo'], $data['email'], $data['password']);
                }
                elseif( $data['route'] === 'deleteUser' ){
                    $this->userController->deleteUser($data['id']);
                }
            }
            elseif(isset($_GET) && !empty($_GET)){
                if($_GET['route'] === 'filters'){
                    $this->proSanteController->workersByFilters($_GET);
                }
                elseif($_GET['route'] === 'users'){
                    $this->userController->getUsers($_GET);
                }
                elseif($_GET['route'] === 'healthworkers'){
                    $this->proSanteController->getHealthWorkers($_GET);
                }
                elseif($_GET['route'] === 'healthworkerById'){
                    $this->proSanteController->getHealthWorkerById($_GET);
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