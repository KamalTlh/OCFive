<?php
namespace controller;

class ProSanteController extends Controller{

    public function getHealthWorkers($get){
        if($_GET['totalPages'] == 0){
            $data['page'] = $this->proSanteModel->getCountListWorkers();
        }
        $data['datas'] = $this->proSanteModel->getListHealthWorkers();
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }

    public function getHealthWorkerById($get){
        $data = $this->proSanteModel->getHealthWorkerById($get);
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }

    public function getListProfessions(){
        $data = $this->proSanteModel->getListProfessions();
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }

    public function getGroupementsActs(){
        $data = $this->proSanteModel->getGroupementsActs();
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }

    public function getRegions(){
        $data = $this->proSanteModel->getRegions();
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }

    public function workersByFilters($get){
        if($_GET['totalPages'] == 0){
            $data['page'] = $this->proSanteModel->getCountWorkersByFilters($get);
        }
        $data['datas'] = $this->proSanteModel->gethealthWorkersByFilters($get);
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }
}