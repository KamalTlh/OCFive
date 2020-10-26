<?php
namespace MyApp\Controller;

class CommentController extends Controller{

    public function getListComments($get){
        $check = $this->checkAuth();
        if ($check['access'] === true){
            $accessAdmin = $this->checkAuthAdmin();
            if($accessAdmin['admin'] === true ) {
                if($get['totalPages'] == 0){
                    $data['page'] = $this->commentsModel->getCountListComments();;
                }
                $data['datas'] = $this->commentsModel->getListComments();;
                return $this->view->render('JsonResponse',[
                    'data'=> $data
                ]);
            }
        }
    }

    public function getCommentsOfUser($get){
        $check = $this->checkAuth();
        if ($check['access'] === true){
            if(isset($get['userId'])){
                $data = $this->commentsModel->getCommentsOfUser($get['userId']);
                return $this->view->render('JsonResponse',[
                    'data'=> $data
                ]);
            }
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
        $check = $this->checkAuth();
        if ($check['access'] === true){
            if(isset($post['comment']) && isset($post['userId']) && isset($post['workerId'])){
                $data['errors'] = $this->validation->validate($post, 'Comment');
                $output = $this->checkIfScript($post['comment']);
                if ($output){
                    $post['comment'] = htmlspecialchars($post['comment']);
                }
                if(!($data['errors'])){
                    $data = $this->commentModel->addComment($post['comment'], $post['userId'], $post['workerId']);
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
    }

    public function deleteComment($post){
        $check = $this->checkAuth();
        if ($check['access'] === true){
            $accessAdmin = $this->checkAuthAdmin();
            if($accessAdmin['admin'] === true ){
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
        }
    }

    public function updateComment($post){
        $check = $this->checkAuth();
        if ($check['access'] === true){
            $accessAdmin = $this->checkAuthAdmin();
            if($accessAdmin['admin'] === true ){
                if(isset($post['id']) && $post['content']){
                    $output = $this->checkIfScript($post['content']);
                    if ($output){
                        $post['content'] = htmlspecialchars($post['content']);
                    }
                    $data = $this->commentModel->updateComment($post['id'], $post['content']);
                    return $this->view->render('JsonResponse',[
                        'data'=> $data
                    ]);
                }
                return $this->view->render('JsonResponse',[
                    'data'=> 'Erreur lors du traitement des données. Veuillez réessayer plus tard.'
                ]);
            }
        }
    }

    public function flagComment($post){
        $check = $this->checkAuth();
        if ($check['access'] === true){
            if (isset($post['commentId'])){
                $data = $this->commentModel->flagComment($post['commentId']);
                return $this->view->render('JsonResponse',[
                    'data'=> $data
                ]);
            }
            return $this->view->render('JsonResponse',[
                'data'=> 'Erreur lors du traitement des données. Veuillez réessayer plus tard.'
            ]);
        }
    }

    public function unflagComment($post){
        $check = $this->checkAuth();
        if ($check['access'] === true){
            if (isset($post['commentId'])){
                $data = $this->commentModel->unflagComment($post['commentId']);
                return $this->view->render('JsonResponse',[
                    'data'=> $data
                ]);
            }
            return $this->view->render('JsonResponse',[
                'data'=> 'Erreur lors du traitement des données. Veuillez réessayer plus tard.'
            ]);
        }
    }
}