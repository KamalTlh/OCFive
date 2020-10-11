<?php
namespace MyApp\Model;
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
        $users = [];
        $usersResult = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach( $result as $row){
            $user = new UserModel();
            $userId = $row['id'];
            $users[$userId] = $user->hydrate($row);
        }
        $result->closeCursor();
        $data['currentPage'] = $pagination['currentPage'];
        $data['users'] = $usersResult;
        $this->setUsers($users);
        return $data;
    }
}