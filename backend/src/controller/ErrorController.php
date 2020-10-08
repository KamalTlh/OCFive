<?php
namespace MyApp\Controller;

class ErrorController extends Controller{

    public function errorPage(){
        return $this->view->render('error404', []);
    }

    public function errorServer(){
        return $this->view->render('error500', []);
    }

    public function errorData(){
        $data['errorData'] = true;
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }
}