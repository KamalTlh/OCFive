<?php
namespace MyApp\Model;
use PDO; 
class ProsSanteModel extends Model {

    private $healthworkers;

    public function getHealthWorkers(){
        return $this->healthworkers;
    }

    public function setHealthWorkers($workers){
        $this->healthworkers = $healthworkers;
    }

    // public function getCountListWorkers(){
    //     $query = 'SELECT id FROM annuaire';
    //     $result = $this->createQuery($query);
    //     $results = $result->fetchAll(PDO::FETCH_ASSOC);
    //     $data = $this->dataPagination($results);
    //     return $data;
    // }

    // public function getListHealthWorkers(){
    //     $pagination = $this->getPagePagination();
    //     $sql = 'SELECT civilite, nom_professionnel, adresse, telephone, profession, commune, region, contact FROM annuaire LIMIT '.$pagination['limite'].' OFFSET '.$pagination['debut'];
    //     $result = $this->createQuery($sql);
    //     $healthworkers = $result->fetchAll(PDO::FETCH_ASSOC);
    //     $data['currentPage'] = $pagination['currentPage'];
    //     $data['healthworkers'] = $healthworkers;
    //     return $data;
    // }
}