<?php
namespace controller;

class FavoritesController extends Controller{

    public function addFavorites($post){
        if(isset($post['userId']) && isset($post['workerId'])){
            $data = $this->favoritesModel->addFavorites($post['userId'], $post['workerId']);
            return $this->view->render('JsonResponse',[
                'data'=> $data
            ]);
        }
    }

    public function getFavoritesOfUser($post){
        if(isset($post['userId'])){
            $data = $this->favoritesModel->getFavoritesOfUser($post['userId']);
            return $this->view->render('JsonResponse',[
                'data'=> $data
            ]);
        }
    }
}