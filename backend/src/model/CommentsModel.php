<?php
namespace MyApp\Model;
use PDO; 

class CommentsModel extends Model{

    private $comments;

    public function getComments(){
        return $this->comments;
    }

    public function setComments($comments){
        $this->comments = $comments;
    }

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
        // $comments = [];
        // foreach($result as $row){
        //     $comment = new CommentModel();
        //     $commentId = $row['id'];
        //     $comments[$commentId] = $comment->hydrate($row);
        // }
        // $result->closeCursor();
        $commentsOfUser = $result->fetchAll(PDO::FETCH_ASSOC);
        $data['success'] = true;
        $data['number'] = count($commentsOfUser);
        $data['commentsOfUser'] = $commentsOfUser;
        return $data;
        // $this->setComments($comments);
        // return $comments;
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
        $sql = 'SELECT * FROM comment ORDER BY workerId ASC LIMIT '.$pagination['limite'].' OFFSET '.$pagination['debut'];
        $result = $this->createQuery($sql);
        $comments = [];
        $commentsResult = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach( $result as $row){
            $comment = new CommentModel();
            $commentId = $row['id'];
            $comments[$commentId] = $comment->hydrate($row);
        }
        $result->closeCursor();
        $data['currentPage'] = $pagination['currentPage'];
        $data['comments'] = $commentsResult;
        $this->setComments($comments);
        return $data;

        // $sql= 'SELECT * FROM comment ORDER BY id ASC';
        // $result = $this->createQuery($sql, [$workerId]);
        // $comments = $result->fetchAll(PDO::FETCH_ASSOC);
        // $data['success'] = true;
        // $data['number'] = count($comments);
        // $data['comments'] = $comments;
        // return $data;
    }

    // public function getListComments(){
    //     $sql= 'SELECT * FROM comment ORDER BY flag DESC';
    //     $result = $this->createQuery($sql);
    //     $comments = [];
    //     foreach($result as $row){
    //         $comment = new CommentModel();
    //         $commentId = $row['id'];
    //         $comments[$commentId] = $comment->hydrate($row);
    //     }
    //     $result->closeCursor();
    //     $this->setComments($comments);
    //     return $comments;
    // }

    // public function getCommentsFromArticle($articleId){
    //     $sql = 'SELECT id, pseudo, content, date_creation, flag, article_id FROM comment WHERE article_id = ? ORDER BY date_creation DESC';
    //     $result = $this->createQuery($sql, [$articleId]);
    //     $comments = [];
    //     foreach($result as $row){
    //         $comment = new CommentModel();
    //         $commentId = $row['id'];
    //         $comments[$commentId] = $comment->hydrate($row);
    //     }
    //     $result->closeCursor();
    //     $this->setComments($comments);
    //     return $comments;
    // }

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