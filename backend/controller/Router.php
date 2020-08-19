<?php
namespace controller;

class Router{
    private $proSanteController;
    private $commentController;
    private $errorController;
    private $userController;
    private $jsonReceiveData;
    private $json_output;
    private $task;
    private $uniquekey;
    
    public function __construct(){
        $this->proSanteController = new ProSanteController();
        $this->commentController = new CommentController();
        $this->errorController = new ErrorController();
        $this->userController = new UserController();
    }

    public function run(){
        try{
            if(isset($_POST)){
                $data = json_decode(file_get_contents("php://input"), true);
                if( $data['route'] === 'login'){
                    $this->userController->login($data['pseudo'], $data['password']);
                }
            }
            elseif(isset($_GET)){
                if($_GET['route'] === 'filters'){
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