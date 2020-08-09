<?php
namespace model;
use PDO; 

class ProSanteModel extends Model {
    private $id;
    private $civilite;
    private $nom_professionnel;
    private $adresse;
    private $telephone;
    private $profession;
    private $coordonnees;
    private $commune;
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
    

   function getNomprofessionnel() { 
        return $this->nom_professionnel; 
   } 

   function setNomprofessionnel($nomprofessionnel) {  
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

   function getCodepostal() { 
        return $this->codepostal; 
   } 

   function setCodepostal($codepostal) {  
       $this->codepostal = $codepostal; 
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

    public function hydrate(array $donnees){
        foreach ($donnees as $key => $value){
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

    public function setPagination(){
        $page = (!empty($_GET['page']) ? $_GET['page'] : 1);
        $limit = 20;
        // Partie "Requête"
        $start = ($page - 1) * $limite;
        $sql = 'SELECT * FROM `my_table` LIMIT :limit OFFSET :start';
        $result = $this->createquery($sql, [
                    'limit'=>$limit,
                    'start'=>$start
        ]);
        $healthworkers = $result->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <a href="?page=<?php echo $page - 1; ?>">Page précédente</a>
        —
        <a href="?page=<?php echo $page + 1; ?>">Page suivante</a>
        <?php
    }

    public function gethealthWorker($workerId){
        $sql = ' SELECT * FROM search_pro WHERE id = ? ';
        $result = $this->createQuery($sql, [$workerId]);
        $healthworker = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = array();
        $data['success'] = true;
        $data['number'] = count($healthworker);
        $data['healthworkers'] = $healthworker;
        return $data;
    }

    public function gethealthWorkersByFilters($get){
        $filters = [];
        $data = [];
        foreach($get as $key => $value){
            if(isset($key)){
               $filters[$key]= $value;
            }
        }
        $query = 'SELECT id FROM search_pro WHERE commune=:commune AND civilite=:civilite AND profession=:profession';
        $result = $this->createQuery($query, [ 
            ':commune' => $get['commune'],
            ':civilite' => $get['civilite'],
            ':profession' => $get['profession']
        ]);
        $results = $result->fetchAll(PDO::FETCH_ASSOC);
        $totalResult = Count($results);
        if ( isset($_GET['page']) AND !empty($_GET['page']) ){
            $_GET['page'] = intval($_GET['page']);
            $currentPage = $_GET['page'];
        } else {
            $currentPage = 1;
        }
        $limite = intval(20);
        $data ['totalPages'] = ceil($totalResult/$limite);
        $debut = ($currentPage - 1) * $limite;
        $sql = ' SELECT civilite, nom_professionnel, adresse, telephone, profession, commune, region, contact FROM search_pro WHERE commune=:commune AND civilite=:civilite AND profession=:profession LIMIT '.$limite.' OFFSET '.$debut; 
        $result = $this->createQuery($sql, [ 
            ':commune' => $get['commune'],
            ':civilite' => $get['civilite'],
            ':profession' => $get['profession']
        ]);
        $healthworker = $result->fetchAll(PDO::FETCH_ASSOC);
        $data['success'] = true;
        $data['number'] = count($healthworker);
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