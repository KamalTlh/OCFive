<?php
namespace model;
use PDO; 

class ProSanteModel extends Model {
    private $id; /* =1 */
    private $civilite = '%';
    private $nom_professionnel = '%';
    private $adresse = '%';
    private $telephone = '%';
    private $profession = '%';
    private $coordonnees;
    private $commune = '%';
    private $departement;
    private $region ='%';
    private $contact = '%';
    private $regroupement = '%';
    private $nature_exercice = '%';
    private $sesam_vitale;

    function getCivilite() { 
        return $this->civilite; 
   } 

   function setCivilite($civilite) {  
       $this->civilite = $civilite; 
   }
    
   function getNom_professionnel() { 
        return $this->nom_professionnel; 
   } 

   function setNom_professionnel($nom_professionnel) {  
       $this->nom_professionnel = $nom_professionnel; 
   } 

   function getAdresse() { 
        return $this->adresse; 
   } 

   function setAdresse($adresse) {  
       $this->adresse = $adresse; 
   } 

   function getTelephone() { 
        return $this->telephone; 
   } 

   function setTelephone($telephone) {  
       $this->telephone = $telephone; 
   } 

   function getProfession() { 
        return $this->profession; 
   } 

   function setProfession($profession) {  
       $this->profession = $profession; 
   }

   function getCoordonnees() { 
        return $this->coordonnees; 
    } 

    function setCoordonnees($coordonnees) {  
        $this->coordonnees = $coordonnees; 
    } 

    function getCommune() { 
        return $this->commune; 
    } 

    function setCommune($commune) {  
        $this->commune = $commune; 
    } 

    function getDepartement() { 
        return $this->departement; 
    } 

    function setDepartement($departement) {  
        $this->departement = $departement; 
    } 

    function getRegion() { 
        return $this->region; 
    } 

    function setRegion($region) {  
        $this->region = $region; 
    } 

    function getContact() { 
        return $this->contact; 
    } 

    function setContact($contact) {  
        $this->contact = $contact; 
    } 

   function getNature_exercice() { 
        return $this->nature_exercice; 
   } 

   function setNature_exercice($nature_exercice) {  
       $this->nature_exercice = $nature_exercice; 
   } 

   function getSesam_vitale() { 
        return $this->sesam_vitale; 
   } 

   function setSesamvitale($sesam_vitale) {  
       $this->sesam_vitale = $sesam_vitale; 
   } 

   function getRegroupement() { 
        return $this->regroupement; 
   } 

   function setRegroupement($regroupement) {  
       $this->regroupement = $regroupement; 
   } 

    public function hydrate(array $get){
        foreach ($get as $key => $value){
            // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set'.ucfirst($key);
            // Si le setter correspondant existe.
            if (method_exists($this, $method)){
            // On appelle le setter.
            $this->$method($value);
            }
        }
        return $this;
    }

    public function gethealthWorkerById($get){
        $sql = ' SELECT * FROM annuaire WHERE id = ? ';
        $result = $this->createQuery($sql, [$get['id']]);
        $healthworker = $result->fetch(PDO::FETCH_ASSOC);
        $data['success'] = true;
        $data['number'] = count($healthworker);
        $data['healthworker'] = $healthworker;
        return $data;
    }

    public function getCountListWorkers(){
        $query = 'SELECT id FROM annuaire';
        $result = $this->createQuery($query);
        $results = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = $this->dataPagination($results);
        return $data;
    }

    public function getListHealthWorkers(){
        $pagination = $this->getPagePagination();
        $sql = 'SELECT id, civilite, nom_professionnel, adresse, telephone, profession, commune, region FROM annuaire ORDER BY id ASC LIMIT '.$pagination['limite'].' OFFSET '.$pagination['debut'];
        $result = $this->createQuery($sql);
        $healthworkers = $result->fetchAll(PDO::FETCH_ASSOC);
        $data['currentPage'] = $pagination['currentPage'];
        $data['healthworkers'] = $healthworkers;
        return $data;
    }

    public function getCountWorkersByFilters($get){
        $this->hydrate($get);
        $query = ' SELECT id FROM annuaire WHERE commune LIKE :commune AND civilite LIKE :civilite AND profession LIKE :profession AND nom_professionnel LIKE :nom_professionnel 
        AND regroupement LIKE :regroupement AND region LIKE :region';
        $result = $this->createQuery($query, [
            ':commune'=>$this->commune,
            ':civilite'=>$this->civilite,
            ':profession'=>$this->profession,
            ':nom_professionnel'=>'%'.$this->nom_professionnel.'%',
            ':regroupement' => $this->regroupement,
            ':region' => $this->region
        ]);
        $results = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = $this->dataPagination($results);
        return $data;
    }

    public function gethealthWorkersByFilters($get){
        $this->hydrate($get);
        $pagination = $this->getPagePagination();
        $sql = ' SELECT id, civilite, nom_professionnel, adresse, telephone, profession, commune, departement, region, coordonnees, regroupement, contact FROM annuaire 
        WHERE commune LIKE :commune AND civilite LIKE :civilite AND profession LIKE :profession AND nom_professionnel LIKE :nom_professionnel AND regroupement LIKE :regroupement 
        AND region LIKE :region ORDER BY nom_professionnel ASC';
        $sql.= ' LIMIT '.$pagination['limite'].' OFFSET '.$pagination['debut']; 
        $result = $this->createQuery($sql, [
            ':commune'=>$this->commune,
            ':civilite'=>$this->civilite,
            ':profession'=>$this->profession,
            ':nom_professionnel'=>'%'.$this->nom_professionnel.'%',
            ':regroupement' => $this->regroupement,
            ':region' => $this->region
        ]);
        $healthworker = $result->fetchAll(PDO::FETCH_ASSOC);
        /*-- Requête pour récupérer les informations qui seront affichés sur le marker de la carte pour un professionnel de santé --*/
        $query = 'SELECT coordonnees, contact, profession FROM annuaire 
        WHERE commune LIKE :commune AND civilite LIKE :civilite AND profession LIKE :profession AND nom_professionnel LIKE :nom_professionnel
        AND regroupement LIKE :regroupement AND region LIKE :region';
        $dataQuery = $this->createQuery($query, [
            ':commune'=>$this->commune,
            ':civilite'=>$this->civilite,
            ':profession'=>$this->profession,
            ':nom_professionnel'=>'%'.$this->nom_professionnel.'%',
            ':regroupement' => $this->regroupement,
            ':region' => $this->region

        ]);
        $coordinates = $dataQuery->fetchAll(PDO::FETCH_ASSOC);
        /*---*/

        $data['currentPage'] = $pagination['currentPage'];
        $data['numberOfResultOnPage'] = count($healthworker);
        $data['healthworkers'] = $healthworker;
        $data['coordinates'] = $coordinates;
        return $data;
    }

    public function getListProfessions(){
        $sql = ' SELECT profession, COUNT(* ) FROM annuaire GROUP BY profession ';
        $result = $this->createQuery($sql);
        $professions = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = array();
        $data['success'] = true;
        $data['number'] = count($professions);
        $data['professions'] = $professions;
        return $data;
    }

    public function getGroupementsActs(){
        $sql = ' SELECT regroupement, COUNT(* ) FROM annuaire GROUP BY regroupement ';
        $result = $this->createQuery($sql);
        $groupementsActs = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = array();
        $data['success'] = true;
        $data['number'] = count($groupementsActs);
        $data['groupementsActs'] = $groupementsActs;
        return $data;
    }

    public function getRegions(){
        $sql = ' SELECT region, COUNT(* ) FROM annuaire GROUP BY region ';
        $result = $this->createQuery($sql);
        $regions = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = array();
        $data['success'] = true;
        $data['number'] = count($regions);
        $data['regions'] = $regions;
        return $data;
    }
}