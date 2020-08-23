<?php
namespace model;
use PDO; 

class ProSanteModel extends Model {
    private $id = 1;
    private $civilite = '%';
    private $nom_professionnel = '%';
    private $adresse = '%';
    private $telephone = '%';
    private $profession = '%';
    private $coordonnees;
    private $commune = '%';
    private $departement;
    private $region;
    private $contact;
    private $regroupement;

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

   function getNatureexercice() { 
        return $this->natureexercice; 
   } 

   function setNatureexercice($natureexercice) {  
       $this->natureexercice = $natureexercice; 
   } 

   function getSesamvitale() { 
        return $this->sesamvitale; 
   } 

   function setSesamvitale($sesamvitale) {  
       $this->sesamvitale = $sesamvitale; 
   } 

   function getRegroupement() { 
        return $this->regroupement; 
   } 

   function setRegroupement($regroupement) {  
       $this->regroupement = $regroupement; 
   } 

   function getLibelleactetechnique() { 
        return $this->libelleactetechnique; 
   } 

   function setLibelleactetechnique($libelleactetechnique) {  
       $this->libelleactetechnique = $libelleactetechnique; 
   } 

   function getActetechniquerealise() { 
        return $this->actetechniquerealise; 
   } 

   function setActetechniquerealise($actetechniquerealise) {  
       $this->actetechniquerealise = $actetechniquerealise; 
   } 

   function getFamilleactetechniquerealise() { 
        return $this->familleactetechniquerealise; 
   } 

   function setFamilleactetechniquerealise($familleactetechniquerealise) {  
       $this->familleactetechniquerealise = $familleactetechniquerealise; 
   } 

   function getActiviteprincipale() { 
        return $this->activiteprincipale; 
   } 

   function setActiviteprincipale($activiteprincipale) {  
       $this->activiteprincipale = $activiteprincipale; 
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
        $sql = ' SELECT * FROM search_pro WHERE id = ? ';
        $result = $this->createQuery($sql, [$get['id']]);
        $healthworker = $result->fetch(PDO::FETCH_ASSOC);
        $data['success'] = true;
        $data['number'] = count($healthworker);
        $data['healthworker'] = $healthworker;
        return $data;
    }

    public function getCountListWorkers(){
        $query = 'SELECT id FROM search_pro';
        $result = $this->createQuery($query);
        $results = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = $this->dataPagination($results);
        return $data;
    }

    public function getListHealthWorkers(){
        $pagination = $this->getPagePagination();
        $sql = 'SELECT id, civilite, nom_professionnel, adresse, telephone, profession, commune, region FROM search_pro ORDER BY id ASC LIMIT '.$pagination['limite'].' OFFSET '.$pagination['debut'];
        $result = $this->createQuery($sql);
        $healthworkers = $result->fetchAll(PDO::FETCH_ASSOC);
        $data['currentPage'] = $pagination['currentPage'];
        $data['healthworkers'] = $healthworkers;
        return $data;
    }

    public function getCountWorkersByFilters($get){
        $this->hydrate($get);
        $query = ' SELECT id FROM search_pro WHERE commune LIKE :commune AND civilite LIKE :civilite AND profession LIKE :profession AND nom_professionnel LIKE :nom_professionnel ';
        $result = $this->createQuery($query, [
            ':commune'=>$this->commune,
            ':civilite'=>$this->civilite,
            ':profession'=>$this->profession,
            ':nom_professionnel'=>'%'.$this->nom_professionnel.'%'

        ]);
        $results = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = $this->dataPagination($results);
        return $data;
    }

    public function gethealthWorkersByFilters($get){
        $this->hydrate($get);
        $pagination = $this->getPagePagination();
        $sql = ' SELECT id, civilite, nom_professionnel, adresse, telephone, profession, commune, region, contact FROM search_pro 
        WHERE commune LIKE :commune AND civilite LIKE :civilite AND profession LIKE :profession AND nom_professionnel LIKE :nom_professionnel';
        $sql.= ' LIMIT '.$pagination['limite'].' OFFSET '.$pagination['debut']; 
        $result = $this->createQuery($sql, [
            ':commune'=>$this->commune,
            ':civilite'=>$this->civilite,
            ':profession'=>$this->profession,
            ':nom_professionnel'=>'%'.$this->nom_professionnel.'%'

        ]);

        $healthworker = $result->fetchAll(PDO::FETCH_ASSOC);
        $data['currentPage'] = $pagination['currentPage'];
        $data['numberOfResultOnPage'] = count($healthworker);
        $data['healthworkers'] = $healthworker;
        return $data;
    }

    public function getListProfessions(){
        $sql = ' SELECT profession, COUNT(* ) FROM search_pro GROUP BY profession ';
        $result = $this->createQuery($sql);
        $professions = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = array();
        $data['success'] = true;
        $data['number'] = count($professions);
        $data['professions'] = $professions;
        return $data;
    }
}