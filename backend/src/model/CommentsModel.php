<?php
namespace MyApp\model;
use PDO; 

class CommentsModel extends Model{

    public function getCountListComments(){
        $query = 'SELECT id FROM comment';
        $result = $this->createQuery($query);
        $results = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = $this->dataPagination($results);
        return $data;
    }

    public function getCommentsOfUser($userId){
        $sql= 'SELECT * FROM comment WHERE userId = ?';
        $result = $this->createQuery($sql, [$userId]);
        $commentsOfUser = $result->fetchAll(PDO::FETCH_ASSOC);
        $data['success'] = true;
        $data['number'] = count($commentsOfUser);
        $data['commentsOfUser'] = $commentsOfUser;
        return $data;
    }

    public function deleteCommentsUser($userId){
        $sql = 'DELETE FROM comment WHERE userId = ?';
        $this->createQuery($sql, [$userId]);
        $data['deleteCommentsUser'] = true;
        return $data ;
    }
    
    public function getCommentsOfWorker($workerId){
        $sql= 'SELECT comment.id, comment.content, comment.date_creation, comment.flag, user.pseudo FROM comment INNER JOIN user ON user.id = comment.userId WHERE workerId = ?';
        $result = $this->createQuery($sql, [$workerId]);
        $commentsOfWorker = $result->fetchAll(PDO::FETCH_ASSOC);
        $data['success'] = true;
        $data['number'] = count($commentsOfWorker);
        $data['commentsOfWorker'] = $commentsOfWorker;
        return $data;;
    }

    public function getListComments(){
        $pagination = $this->getPagePagination();
        $sql = 'SELECT * FROM comment ORDER BY flag DESC LIMIT '.$pagination['limite'].' OFFSET '.$pagination['debut'];
        $result = $this->createQuery($sql);
        $commentsResult = $result->fetchAll(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $data['currentPage'] = $pagination['currentPage'];
        $data['comments'] = $commentsResult;
        return $data;
    }

    public function getFlagComments(){
        $sql = 'SELECT id, pseudo, content, date_creation, flag, article_id FROM comment WHERE flag = 1 ';
        $result = $this->createQuery($sql);
        $flagComments = [];
        foreach ($result as $row){
            $comment = new CommentModel();
            $commentId = $row['id'];
            $flagComments[$commentId] = $comment->hydrate($row);
        }
        $result->closeCursor();
        $this->setComments($flagComments);
        return $flagComments;
    }
}