<?php
namespace MyApp\model;
use PDO; 
class ProsSanteModel extends Model {

    public function getCountListWorkers(){
        $sql = 'SELECT id FROM prossante';
        $result = $this->createQuery($sql);
        $results = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = $this->dataPagination($results);
        return $data;
    }

    /*-- Requête qui récupère la totalité des données sur tout les médecins de la base de donnée trier par ID --*/
    public function getListHealthWorkers(){
        $pagination = $this->getPagePagination();
        $sql = 'SELECT id, civilite, nom_professionnel, adresse, telephone, profession, commune, region FROM prossante ORDER BY id ASC LIMIT '.$pagination['limite'].' OFFSET '.$pagination['debut'];
        $result = $this->createQuery($sql);
        $healthworkers = $result->fetchAll(PDO::FETCH_ASSOC);
        $data['currentPage'] = $pagination['currentPage'];
        $data['healthworkers'] = $healthworkers;
        return $data;
    }
    /*---*/

    /*-- Requête pour récupérer le total des résultats retournés d'une recherche --*/
    public function getCountWorkersByFilters($get){
        $proSante = new ProSanteModel();
        $proSante-> hydrate($get);
        $query = ' SELECT id FROM prossante WHERE commune LIKE :commune AND civilite LIKE :civilite AND profession LIKE :profession AND nom_professionnel LIKE :nom_professionnel 
        AND nom_professionnel LIKE :prenom_professionnel AND mode_exercice LIKE :mode_exercice AND regroupement LIKE :regroupement AND nature_exercice LIKE :statut 
        AND departement LIKE :departement AND region LIKE :region';
        $result = $this->createQuery($query, [
            ':commune'=>$proSante->getCommune(),
            ':civilite'=>$proSante->getCivilite(),
            ':profession'=>$proSante->getProfession(),
            ':nom_professionnel'=>'%'.$proSante->getNom_professionnel().'%',
            ':prenom_professionnel' =>'%'.$proSante->getPrenom_professionnel().'%',
            ':regroupement' => $proSante->getRegroupement(),
            ':statut' => $proSante->getNature_exercice(),
            ':mode_exercice' => $proSante->getMode_exercice(),
            ':departement' => $proSante->getDepartement(),
            ':region' => $proSante->getRegion()
        ]);
        $results = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = $this->dataPagination($results);
        return $data;
    }
    /*---*/

    /*-- Requête de recherche principale selon les données demandées --*/
    public function gethealthWorkersByFilters($get){
        $proSante = new ProSanteModel();
        $proSante-> hydrate($get);
        $pagination = $this->getPagePagination();
        $sql = ' SELECT id, civilite, nom_professionnel, adresse, telephone, profession, coordonnees, commune, departement, region, contact, sesam_vital, convention_cacs, mode_exercice, nature_exercice, regroupement,
        type_acte_realise, acte_technique_realise, famille_acte_technique_realise, note, nb_notes, nb_comments FROM prossante WHERE commune LIKE :commune AND civilite LIKE :civilite AND profession 
        LIKE :profession AND nom_professionnel LIKE :nom_professionnel AND nom_professionnel LIKE :prenom_professionnel AND mode_exercice LIKE :mode_exercice AND 
        regroupement LIKE :regroupement AND nature_exercice LIKE :statut AND departement LIKE :departement AND region LIKE :region ORDER BY note DESC';
        $sql.= ' LIMIT '.$pagination['limite'].' OFFSET '.$pagination['debut']; 
        $result = $this->createQuery($sql, [
            ':commune'=>$proSante->getCommune(),
            ':civilite'=>$proSante->getCivilite(),
            ':profession'=>$proSante->getProfession(),
            ':nom_professionnel'=>'%'.$proSante->getNom_professionnel().'%',
            ':prenom_professionnel' =>'%'.$proSante->getPrenom_professionnel().'%',
            ':regroupement' => $proSante->getRegroupement(),
            ':statut' => $proSante->getNature_exercice(),
            ':mode_exercice' => $proSante->getMode_exercice(),
            ':departement' => $proSante->getDepartement(),
            ':region' => $proSante->getRegion()
        ]);
        $healthworker = $result->fetchAll(PDO::FETCH_ASSOC);
        
        /*-- Requête pour récupérer les informations qui seront affichés sur le marker de la carte pour un professionnel de santé --*/
        $coordinates = $this->getDataByCoordinates($get, $pagination);
        /*---*/

        $data['currentPage'] = $pagination['currentPage'];
        $data['numberOfResultOnPage'] = count($healthworker);
        $data['healthworkers'] = $healthworker;
        $data['coordinates'] = $coordinates;
        return $data;
    }
    /*---*/

    /*-- Fonction qui récupère les informations qui seront affichés sur le marker de la carte pour un professionnel de santé --*/
    public function getDataByCoordinates($get, $pagination){
        $proSante = new ProSanteModel();
        $proSante-> hydrate($get);
        $query = 'SELECT coordonnees, contact, profession, nom_professionnel FROM prossante 
        WHERE commune LIKE :commune AND civilite LIKE :civilite AND profession LIKE :profession AND nom_professionnel LIKE :nom_professionnel AND nom_professionnel LIKE :prenom_professionnel
        AND mode_exercice LIKE :mode_exercice AND regroupement LIKE :regroupement AND nature_exercice LIKE :statut AND departement LIKE :departement AND region LIKE :region ORDER BY nom_professionnel ASC';
        $query.= ' LIMIT '.$pagination['limite'].' OFFSET '.$pagination['debut']; 
        $dataQuery = $this->createQuery($query, [
            ':commune'=>$proSante->getCommune(),
            ':civilite'=>$proSante->getCivilite(),
            ':profession'=>$proSante->getProfession(),
            ':nom_professionnel'=>'%'.$proSante->getNom_professionnel().'%',
            ':prenom_professionnel' =>'%'.$proSante->getPrenom_professionnel().'%',
            ':regroupement' => $proSante->getRegroupement(),
            ':statut' => $proSante->getNature_exercice(),
            ':mode_exercice' => $proSante->getMode_exercice(),
            ':departement' => $proSante->getDepartement(),
            ':region' => $proSante->getRegion()

        ]);
        $coordinates = $dataQuery->fetchAll(PDO::FETCH_ASSOC);
        return $coordinates;
    }

    /*-- Requête pour récupérer les éléments de recherches --*/
    public function getProfessions(){
        $sql = ' SELECT profession, COUNT(* ) FROM prossante GROUP BY profession ORDER BY profession ASC';
        $result = $this->createQuery($sql);
        $professions = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = array();
        $data['success'] = true;
        $data['number'] = count($professions);
        $data['professions'] = $professions;
        return $data;
    }

    public function getGroupementsActs(){
        $sql = ' SELECT regroupement, COUNT(* ) FROM prossante GROUP BY regroupement  ORDER BY regroupement ASC ';
        $result = $this->createQuery($sql);
        $groupementsActs = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = array();
        $data['success'] = true;
        $data['number'] = count($groupementsActs);
        $data['groupementsActs'] = $groupementsActs;
        return $data;
    }

    public function getModeExercices(){
        $sql = ' SELECT mode_exercice, COUNT(* ) FROM prossante GROUP BY mode_exercice  ORDER BY mode_exercice ASC ';
        $result = $this->createQuery($sql);
        $modes_exercice = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = array();
        $data['success'] = true;
        $data['number'] = count($modes_exercice);
        $data['modes_exercice'] = $modes_exercice;
        return $data;
    }

    public function getRegions(){
        $sql = ' SELECT region, COUNT(* ) FROM prossante GROUP BY region ';
        $result = $this->createQuery($sql);
        $regions = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = array();
        $data['success'] = true;
        $data['number'] = count($regions);
        $data['regions'] = $regions;
        return $data;
    }

    public function getCities(){
        $sql = ' SELECT departement, COUNT(* ) FROM prossante GROUP BY departement ';
        $result = $this->createQuery($sql);
        $cities = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = array();
        $data['success'] = true;
        $data['number'] = count($cities);
        $data['departements'] = $cities;
        return $data;
    }
    /*---*/
}