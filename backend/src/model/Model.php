<?php 
namespace MyApp\model;
require "src/config/Datadb.php";
use PDO;
use Exception;

abstract class Model {
    
    private $connection;

    private function checkConnection(){
        if($this->connection===null){
            return $this->getConnection();
        }
        return $connection;
    }

    private function getConnection(){
        try{
            $connection = new PDO(DB_HOST, DB_USER, DB_PASS);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connection;
        }
        catch(Exception $errorConnection)
        {
            die('Erreur de connection: '.$errorConnection->getMessage());
        }
    }

    protected function createQuery($sql, $parameters=NULL){
        if($parameters){
            $result = $this->checkConnection()->prepare($sql);
            $result->execute($parameters);
            return $result;
        }

        $result = $this->checkConnection()->query($sql);
        return $result;
    }

    protected function dataPagination($results){
        $totalResult = Count($results);
        $limite = intval(20);
        $data['success'] = true;
        $data ['totalPages'] = ceil($totalResult/$limite);
        $data['totalResults'] = count($results);
        $data['PerPage'] = $limite;
        return $data;
    }

    protected function getPagePagination(){
        $pagination = [];
        if ( isset($_GET['page']) AND !empty($_GET['page']) ){
            $_GET['page'] = intval($_GET['page']);
            $pagination['currentPage']= $_GET['page'];
        } else {
            $pagination['currentPage'] = 1;
        }
        $pagination['limite'] = intval(20);
        $pagination['debut'] = ($pagination['currentPage']- 1) * $pagination['limite'];
        return $pagination;
    }
}