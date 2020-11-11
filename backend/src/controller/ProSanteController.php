<?php
namespace MyApp\controller;

class ProSanteController extends Controller{

    public function getHealthWorkers($get){
        $check = $this->checkAuth();
        if ($check['access'] === true){
            if($this->checkAuthAdmin()) {
                if($_GET['totalPages'] == 0){
                    $data['page'] = $this->prosSanteModel->getCountListWorkers();
                }
                $data['datas'] = $this->prosSanteModel->getListHealthWorkers();
                return $this->view->render('JsonResponse',[
                    'data'=> $data
                ]);
            }
        }
    }

    public function getHealthWorkerById($get){
        $data = $this->proSanteModel->getHealthWorkerById($get['id']);
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }

    public function getProfessions(){
        $data = $this->prosSanteModel->getProfessions();
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }

    public function getGroupementsActs(){
        $data = $this->prosSanteModel->getGroupementsActs();
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }
    
    public function getModeExercices(){
        $data = $this->prosSanteModel->getModeExercices();
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }

    public function getRegions(){
        $data = $this->prosSanteModel->getRegions();
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }

    public function getCities(){
        $data = $this->prosSanteModel->getCities();
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }

    public function workersByFilters($get){
        if($_GET['totalPages'] == 0){
            $data['page'] = $this->prosSanteModel->getCountWorkersByFilters($get);
        }
        $data['datas'] = $this->prosSanteModel->gethealthWorkersByFilters($get);
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }

    public function addRate($post){
        if(isset($post['rate']) && isset($post['workerId'])){
            $data['rateAdded'] = $this->proSanteModel->addRate($post);
            return $this->view->render('JsonResponse',[
                'data'=> $data
            ]);
        }
        return $this->view->render('JsonResponse',[
            'data'=> 'Erreur lors du traitement des données. Veuillez réessayer plus tard.'
        ]);
    }
}