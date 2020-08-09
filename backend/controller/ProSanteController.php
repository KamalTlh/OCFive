<?php
namespace controller;

class ProSanteController extends Controller{

    public function workers(){
        $data = $this->prosSanteModel->getListHealthWorkers();
        return $this->view->render('Healthworkers',[
            'data'=> $data
        ]);
    }

    public function worker($workerId){
        $data = $this->proSanteModel->gethealthWorker($workerId);
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
        $data = $this->proSanteModel->gethealthWorkersByFilters($get);
        return $this->view->render('Healthworkers',[
            'data'=> $data
        ]);
    }
}