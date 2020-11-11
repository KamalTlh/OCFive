<?php
namespace MyApp\model;
use PDO; 

class FavoritesModel extends Model{

    private $userId;
    private $workerId;

    public function getUserId(){
        return $this->userId;
    }

    public function setUserId($userId){
        $this->userId = $userId;
    }

    public function getWorkerId(){
        return $this->workerId;
    }

    public function setWorkerId($workerId){
        $this->workerId = $workerId;
    }

    public function hydrate(array $donnees){
        foreach ($donnees as $key => $value){
            // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set'.ucfirst($key);
            
            // Si le setter correspondant existe.
            if (method_exists($this, $method)){
            // On appelle le setter.
            $this ->$method($value);
            }
        }
        return $this;
    }

    public function addFavorite($userId, $workerId){
        $sql = 'INSERT INTO favoris (userId, workerId) VALUES (?, ?) ';
        $this->createQuery($sql, [$userId, $workerId]);
        $data['FavoriteAdded'] = true;
        return $data;
    }
    
    public function deleteFavorite($userId, $workerId){
        $sql = 'DELETE FROM favoris WHERE userId = ? AND workerId = ? ';
        $this->createQuery($sql, [$userId, $workerId]);
        $data['deleteFavorite'] = true;
        return $data;
    }

    public function deleteFavoritesUser($userId){
        $sql = 'DELETE FROM favoris WHERE userId = ?';
        $this->createQuery($sql, [$userId]);
        $data['deleteFavoritesUser'] = true;
        return $data;
    }

    public function getFavoritesOfUser($userId){
        $sql = 'SELECT * FROM annuaire INNER JOIN favoris on favoris.workerId = annuaire.id AND favoris.userId = ? ';
        $result = $this->createQuery($sql, [$userId]);
        $favoritesOfUser = $result->fetchAll(PDO::FETCH_ASSOC);
        $data['success'] = true;
        $data['number'] = count($favoritesOfUser);
        $data['favoritesOfUser'] = $favoritesOfUser;
        return $data;
    }
}