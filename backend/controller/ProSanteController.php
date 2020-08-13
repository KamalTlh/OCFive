<?php
namespace controller;

class ProSanteController extends Controller{

    public function workers($get){
        if($_GET['totalPages'] == 0){
            $data['page'] = $this->prosSanteModel->getCountListWorkers();
        }
        $data['datas'] = $this->prosSanteModel->getListHealthWorkers();
        return $this->view->render('Healthworkers',[
            'data'=> $data
        ]);
    }

    public function getListProfessions(){
        $data = $this->proSanteModel->getListProfessions();
        return $this->view->render('Healthworkers',[
            'data'=> $data
        ]);
    }

    public function workersByFilters($get){
        if($_GET['totalPages'] == 0){
            $data['page'] = $this->proSanteModel->getCountWorkersByFilters($get);
        }
        $data['datas'] = $this->proSanteModel->gethealthWorkersByFilters($get);
        return $this->view->render('Healthworkers',[
            'data'=> $data
        ]);
    }
}