<?php
namespace MyApp\model;
use PDO;

class CommentModel extends Model{
 
    private $id;
    private $content;
    private $date_creation;
    private $flag;
    private $userId;
    private $workerId;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }
    
    public function getContent(){
        return $this->content;
    }

    public function setContent($content){
        $this->content = $content;
    }

    public function getDate_Creation(){
        return $this->date_creation;
    }

    public function setDate_Creation($date_creation){
        $this->date_creation = $date_creation;
    }

    public function getFlag(){
        return $this->flag;
    }

    public function setFlag($flag){
        $this->flag = $flag;
    }

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
            $this->$method($value);
            }
        }
        return $this;
    }

    public function getComment($commentId){
        $sql = 'SELECT id, pseudo, content, date_creation, flag, article_id FROM comment WHERE id = ?';
        $result = $this->createQuery($sql, [$commentId]);
        $comment = $result->fetch();
        $result->closeCursor();
        return $this->hydrate($comment);
    }

    public function addComment($comment, $userId, $workerId){
        $firstQuery = 'INSERT INTO comment (content, date_creation, flag, userId, workerId) VALUES (?, NOW(), ?, ?, ?)';
        $this->createQuery($firstQuery, [$comment, 0, $userId, $workerId]);
        $secondQuery = 'SELECT nb_comments FROM annuaire WHERE id = ?';
        $result = $this->createQuery($secondQuery, [$workerId]);
        $nb_comments = $result->fetch(PDO::FETCH_ASSOC);
        $new_NbComments = intval($nb_comments['nb_comments']) + 1;
        $thirdQuery = 'UPDATE annuaire SET nb_comments = ? WHERE id = ?';
        $this->createQuery($thirdQuery, [ $new_NbComments, $workerId]);
        $lastQuery = 'SELECT comment.id, comment.content, comment.date_creation, comment.flag, user.pseudo FROM comment INNER JOIN user ON user.id = comment.userId WHERE content = ? AND userId = ? AND workerID = ?';
        $lastResult = $this->createQuery($lastQuery, [$comment, $userId, $workerId]);
        $commentAdded = $lastResult->fetch(PDO::FETCH_ASSOC);
        $data['commentAdded'] = $commentAdded;
        return $data;
    }

    public function updateComment($commentId, $content){
        $sql = 'UPDATE comment SET content = ? WHERE id = ?';
        $this->createQuery($sql, [strip_tags($content), $commentId]);
        $data['commentUpdated'] = true;
        $data['newComment'] = $content;
        return $data;
    }

    public function deleteComment($commentId){
        $sql = 'DELETE FROM comment WHERE id = ?';
        $this->createQuery($sql, [$commentId]);
        return true ;
    }

    public function flagComment($commentId){
        $sql = 'UPDATE comment SET flag = ? WHERE id = ?';
        $this->createQuery($sql, [1, $commentId]);
        $data['commentFlag'] = true;
        return $data;
    }

    public function unflagComment($commentId){
        $sql = 'UPDATE comment SET flag = ? WHERE id = ?';
        $this->createQuery($sql, [0, $commentId]);
        $data['commentUnflag'] = true;
        return $data;
    }
}