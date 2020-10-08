<?php
namespace controller;

class CommentController extends Controller{

    public function getListComments($get){
        if($get['userLoggedRole'] == 1 ) {
            if($get['totalPages'] == 0){
                $data['page'] = $this->commentsModel->getCountListComments();;
            }
            $data['datas'] = $this->commentsModel->getListComments();;
            return $this->view->render('JsonResponse',[
                'data'=> $data
            ]);
        }
        return $this->view->render('JsonResponse',[
            'data'=> 'Vous n\'avez pas les droits d\'accès.'
        ]);
    }

    public function getCommentsOfUser($get){
        if(isset($get['userId'])){
            $data = $this->commentsModel->getCommentsOfUser($get['userId']);
            return $this->view->render('JsonResponse',[
                'data'=> $data
            ]);
        }
    }

    public function getCommentsOfWorker($get){
        if(isset($get['workerId'])){
            $data = $this->commentsModel->getCommentsOfWorker($get['workerId']);
            return $this->view->render('JsonResponse',[
                'data'=> $data
            ]);
        }
    }

    public function addComment($post){
        if(isset($post['comment']) && isset($post['userId']) && isset($post['workerId'])){
            $data['errors'] = $this->validation->validate($post, 'Comment');
            if(!($data['errors'])){
                $data = $this->commentModel->addComment($post);
                return $this->view->render('JsonResponse',[
                    'data'=> $data
                ]);
            }
            return $this->view->render('JsonResponse',[
                'data'=> $data
            ]);
        }
        return $this->view->render('JsonResponse',[
            'data'=> 'Erreur lors du traitement des données. Veuillez réessayer plus tard.'
        ]);
    }

    public function deleteComment($post){
        if(isset($post['id'])){
            $data['commentDeleted'] = $this->commentModel->deleteComment($post['id']);
            return $this->view->render('JsonResponse',[
                'data'=> $data
            ]);
        }
        return $this->view->render('JsonResponse',[
            'data'=> 'Erreur lors du traitement des données. Veuillez réessayer plus tard.'
        ]);
    }

    public function updateComment($post, $commentId){
        if($this->checkAdmin()){
            $comment = $this->commentModel->getComment($commentId);
            $article = $this->articleModel->getArticle($comment->getArticle_Id());
            if(isset($post['submit'])){
                $this->commentModel->updateComment($post, $commentId);
                $this->session->set('update_comment', 'Le commentaire a bien été modifié.');
                header('Location: index.php?route=readarticle&articleId='.$comment->getArticle_Id());
            }
            return $this->view->render('updatecomment', [
                'comment'=>$comment,
                'article'=>$article
            ]);
        }
    }

    public function flagComment($commentId){
        if($this->checkLoggedIn()){
            $comment = $this->commentModel->getComment($commentId);
            $this->commentModel->flagComment($commentId);
            $this->session->set('flag_comment', 'Le commentaire a bien été signalé.');
            header('Location: index.php?route=readarticle&articleId='.$comment->getArticle_Id());
        }
    }

    public function unflagComment($commentId){
        if($this->checkLoggedIn()){
            $comment = $this->commentModel->getComment($commentId);
            $this->commentModel->unflagComment($commentId);
            $this->session->set('unflag_comment', 'Le commentaire n\'est plus signalé.');
            header('Location: index.php?route=administration');
        }
    }
}