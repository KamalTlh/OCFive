<?php
namespace controller;

class Router{
    private $proSanteController;
    private $commentController;
    private $errorController;
    private $userController;
    private $favoritesController;
    private $field_data;
    
    public function __construct(){
        $this->proSanteController = new ProSanteController();
        $this->commentController = new CommentController();
        $this->errorController = new ErrorController();
        $this->userController = new UserController();
        $this->favoritesController = new FavoritesController();
    }

    public function run(){
        try{
            $data = json_decode(file_get_contents("php://input"), true);
            if(isset($data) && !empty($data)){
                if( $data['route'] === 'login' ){
                    $this->userController->login($data);
                }
                elseif( $data['route'] === 'logout' ){
                    $this->userController->logout();
                }
                elseif( $data['route'] === 'signIn' ){
                    $this->userController->signIn($data);
                }
                elseif( $data['route'] === 'updateUser' ){
                    $this->userController->updateUser($data);
                }
                elseif( $data['route'] === 'deleteUser' ){
                    $this->userController->deleteUser($data);
                }
                elseif( $data['route'] === 'updatePassword' ){
                    $this->userController->updatePassword($data);
                }
                elseif( $data['route'] === 'addFavorites' ){
                    $this->favoritesController->addFavorites($data);
                }
            }
            elseif(isset($_GET) && !empty($_GET)){
                if($_GET['route'] === 'filters'){
                    /* Vérification que les champs de recherche envoyé coté FrontEnd ne soit pas null */
                    $this->field_data = 0;
                    foreach ($_GET as $key => $value){
                        if($key != 'route' && $key != 'page' && $key != 'totalPages'){
                            $this->field_data += 1;
                        }
                    }
                    if ($this->field_data == 0){
                        $this->errorController->errorData(); 
                    }
                    else {
                        $this->proSanteController->workersByFilters($_GET);
                    }
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
                elseif($_GET['route'] === 'professions'){
                    $this->proSanteController->getProfessions();
                }
                elseif($_GET['route'] === 'groupementsActs'){
                    $this->proSanteController->getGroupementsActs();
                }
                elseif($_GET['route'] === 'modes_exercice'){
                    $this->proSanteController->getModeExercices();
                }
                elseif($_GET['route'] === 'regions'){
                    $this->proSanteController->getRegions();
                }
                elseif($_GET['route'] === 'cities'){
                    $this->proSanteController->getCities();
                }
                elseif($_GET['route'] === 'userFavorites'){
                    $this->favoritesController->getFavoritesOfUser($_GET);
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