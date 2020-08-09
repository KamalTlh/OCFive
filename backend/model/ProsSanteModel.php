<?php
namespace model;
use PDO; 
class ProsSanteModel extends Model {

    private $healthworkers;

    public function getHealthWorkers(){
        return $this->healthworkers;
    }

    public function setHealthWorkers($workers){
        $this->healthworkers = $healthworkers;
    }

    public function getListHealthWorkers(){
        $sql = 'SELECT civilite, nom_professionnel, adresse, telephone, profession, commune, region, contact FROM search_pro LIMIT 50';
        $result = $this->createQuery($sql);
        $healthworkers = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = array();
        $data['success'] = true;
        $data['number'] = count($healthworkers);
        $data['healthworkers'] = $healthworkers;
        return $data;
    }
}