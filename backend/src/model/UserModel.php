<?php
namespace MyApp\model;
use PDO; 

class UserModel extends Model{

    private $id;
    private $pseudo;
    private $email;
    private $password;
    private $date_creation;
    private $role_id;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getPseudo(){
        return $this->pseudo;
    }

    public function setPseudo($pseudo){
        $this->pseudo = $pseudo;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }
    
    public function getPassword(){
        return $this->password;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getDate_Creation(){
        return $this->date_creation;
    }

    public function setDate_Creation($date_creation){
        $this->date_creation = $date_creation;
    }

    public function getRole_Id(){
        return $this->role_id;
    }

    public function setRole_Id($role_id){
        $this->role_id = $role_id;
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

    public function getUser($userId){
        $sql = 'SELECT id, pseudo, email, date_creation, role_id FROM user WHERE id = ?';
        $result = $this->createQuery($sql, [$userId]);
        $user = $result->fetch();
        $result->closeCursor();
        return $this->hydrate($user);
    }
    
    public function login($pseudo, $password){
        $checkingSql = ' SELECT password FROM user WHERE pseudo = ?';
        $data = $this->createQuery($checkingSql, [ $pseudo ]);
        $result = $data->fetch(PDO::FETCH_ASSOC);
        $isPasswordValid = isset($result) ? password_verify($password, $result['password']) : false;
        if ( $isPasswordValid ) {
            $sql = 'SELECT id, pseudo, email, date_creation, role_id FROM user WHERE pseudo = ?';
            $data = $this->createQuery($sql, [ $pseudo ]);
            $result = $data->fetch(PDO::FETCH_ASSOC);
            return [
                'user'=> $result,
                'isPasswordValid'=> $isPasswordValid
            ];
        }
        return [
            'isPasswordValid'=> $isPasswordValid
        ];
    }

    public function signIn($pseudo, $email, $password){
        $sql = 'INSERT INTO user (pseudo, email, password, date_creation, role_id) VALUES (?, ?, ?, NOW(), 2)';
        $this->createQuery($sql, [htmlspecialchars($pseudo), htmlspecialchars($email), password_hash($password,PASSWORD_BCRYPT)]);
        return [
            'registration'=> true
        ];
    }

    public function updateUser($post){
        $sql =' UPDATE user SET pseudo = ?, email = ? WHERE id = ?';
        $this->createQuery($sql, [htmlspecialchars($post['pseudo']), htmlspecialchars($post['email']), $post['id']]);
        return [
            'userUpdated'=> true
        ];
    }

    public function updateUserByAdmin($post){
        $sql =' UPDATE user SET pseudo = ?, email = ? WHERE id = ?';
        $this->createQuery($sql, [htmlspecialchars($post['pseudo']), htmlspecialchars($post['email']), $post['id']]);
        return [
            'userUpdatedByAdmin'=> true
        ];
    }


    public function deleteUser($userId){
        $sql = 'DELETE FROM user WHERE id = ?';
        $this->createQuery($sql, [$userId]);
        $data['isDelete'] = true;
        return $data;
    }

    public function checkPassword($currentPassword, $userId){
        $checkingSql = ' SELECT password FROM user WHERE id = ?';
        $dataSql = $this->createQuery($checkingSql, [ $userId ]);
        $result = $dataSql->fetch(PDO::FETCH_ASSOC);
        $isPasswordValid = password_verify($currentPassword, $result['password']);
        return $isPasswordValid;
    }

    public function updatePassword($password, $userId){
        $sql =' UPDATE user SET password = ? WHERE id = ?';
        $this->createQuery($sql, [password_hash($password, PASSWORD_BCRYPT), $userId]);
        return $data['passwordUpdated'] = true;
    }

    public function checkUserRole($userlog){
        $sql = 'SELECT role_id FROM user WHERE pseudo = ? OR email = ?';
        $data = $this->createQuery($sql, [$userlog, $userlog]);
        $result = $data->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function isPseudoUnique($post, $userId){
        $sql = 'SELECT COUNT(pseudo) FROM user WHERE pseudo = ? AND id != ?';
        $result = $this->createQuery($sql, [$post['pseudo'], $userId]);
        $isPseudoUnique = $result->fetch(PDO::FETCH_ASSOC);
        if($isPseudoUnique['COUNT(pseudo)'] > 0) {
            return 'Le pseudo existe déjà';
        }
    }

    public function isEmailUnique($post, $userId){
        $sql = 'SELECT COUNT(email) FROM user WHERE email = ? AND id != ?';
        $result = $this->createQuery($sql, [$post['email'], $userId]);
        $isEmailUnique = $result->fetch(PDO::FETCH_ASSOC);
        if($isEmailUnique['COUNT(email)'] > 0) {
            return 'L\'email existe déjà';
        }
    }

    public function getRoleName($role_id){
        $sql = 'SELECT name FROM role WHERE id = ?';
        $data = $this->createQuery($sql, [$role_id]);
        $result = $data -> fetch(PDO::FETCH_ASSOC);
        return $result['name'];
    }

    public function getUserPreferences($userId, $workerId){
        $firstQuery = 'SELECT COUNT(id) as ifFavorite FROM favoris WHERE userId = ? AND workerId = ?';
        $firstResult = $this->createQuery($firstQuery, [$userId, $workerId]);
        $ifFavorite = $firstResult->fetch(PDO::FETCH_ASSOC);
        $data['ifFavorite'] = $ifFavorite;
        $secondQuery = 'SELECT COUNT(id) as ifRated FROM rate WHERE userId = ? AND workerId = ?';
        $secondResult = $this->createQuery($secondQuery, [$userId, $workerId]);
        $ifRated = $secondResult->fetch(PDO::FETCH_ASSOC);
        $data['ifRated'] = $ifRated;
        return $data;
    }

}