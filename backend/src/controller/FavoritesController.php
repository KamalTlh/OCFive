<?php
namespace MyApp\Controller;

class FavoritesController extends Controller{

    public function addFavorite($post){
        if(isset($post['userId']) && isset($post['workerId'])){
            $data = $this->favoritesModel->addFavorite($post['userId'], $post['workerId']);
            return $this->view->render('JsonResponse',[
                'data'=> $data
            ]);
        }
    }

    public function deleteFavorite($post){
        if(isset($post['userId']) && isset($post['workerId'])){
            $data = $this->favoritesModel->deleteFavorite($post['userId'], $post['workerId']);
            return $this->view->render('JsonResponse',[
                'data'=> $data
            ]);
        }
    }

    public function getFavoritesOfUser($post){
        $check = $this->checkAuth();
        if ($check['access'] === true){
            if(isset($post['userId'])){
                $data = $this->favoritesModel->getFavoritesOfUser($post['userId']);
                return $this->view->render('JsonResponse',[
                    'data'=> $data
                ]);
            }
        }else {
            return $this->view->render('JsonResponse',[
                'Denied' => 'Access Denied'
            ]);
        }
    }
}