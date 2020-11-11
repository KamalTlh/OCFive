<?php
namespace MyApp\model;
use PDO;

class UsersModel extends Model{

    private $users;

    public function getUsers(){
        return $this->users;
    }

    public function setUsers($users){
        $this->users = $users;
    }

    public function getCountListUsers(){
        $query = 'SELECT id FROM user';
        $result = $this->createQuery($query);
        $results = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = $this->dataPagination($results);
        return $data;
    }

    public function getListUsers(){
        $pagination = $this->getPagePagination();
        $sql = 'SELECT id, pseudo, email, date_creation, role_id FROM user LIMIT '.$pagination['limite'].' OFFSET '.$pagination['debut'];
        $result = $this->createQuery($sql);
        $usersResult = $result->fetchAll(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $data['currentPage'] = $pagination['currentPage'];
        $data['users'] = $usersResult;
        return $data;
    }
}