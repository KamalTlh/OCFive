<?php
namespace model;
use PDO; 

class ProSanteModel extends Model {
    private $id; /* =1 */
    private $civilite = '%';
    private $nom_professionnel = '%';
    private $prenom_professionnel = '%';
    private $adresse = '%';
    private $telephone = '%';
    private $profession = '%';
    private $coordonnees;
    private $commune = '%';
    private $departement = '%';
    private $region ='%';
    private $contact = '%';
    private $regroupement = '%';
    private $nature_exercice = '%';
    private $mode_exercice = '%';
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

    function getPrenom_professionnel() { 
        return $this->prenom_professionnel; 
    } 

    function setPrenom_professionnel($prenom_professionnel) {  
        $this->prenom_professionnel = $prenom_professionnel; 
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

    function getMode_exerice() { 
        return $this->mode_exercice; 
    } 

    function setMode_exercice($mode_exercice) {  
    $this->mode_exercice = $mode_exercice; 
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
            //Si on a des champs de recherche vide on les initialise à '%' pour inclure toutes les possibilités dans les resultats retournés.
            if ($value == ''){
                $value = '%';
            }
            $value = str_replace("'","\'",$value);
            // echo $key.' -> '.$value.'<br>';
            // Si le setter correspondant existe.
            if (method_exists($this, $method)){
                // On appelle le setter.
                $this->$method($value);
            }
        }
        return $this;
    }

    public function getHealthWorkerById($workerId){
        $sql = 'SELECT * FROM annuaire WHERE id = ?';
        $result = $this->createQuery($sql, [$workerId]);
        $healthworker = $result->fetch(PDO::FETCH_ASSOC);
        $data['healthworker'] = $healthworker;
        return $data;
    }

    public function getCountListWorkers(){
        $sql = 'SELECT id FROM annuaire';
        $result = $this->createQuery($sql);
        $results = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = $this->dataPagination($results);
        return $data;
    }

    /*-- Requête qui récupère la totalité des données sur tout les médecins de la base de donnée trier par ID --*/
    public function getListHealthWorkers(){
        $pagination = $this->getPagePagination();
        $sql = 'SELECT id, civilite, nom_professionnel, adresse, telephone, profession, commune, region FROM annuaire ORDER BY id ASC LIMIT '.$pagination['limite'].' OFFSET '.$pagination['debut'];
        $result = $this->createQuery($sql);
        $healthworkers = $result->fetchAll(PDO::FETCH_ASSOC);
        $data['currentPage'] = $pagination['currentPage'];
        $data['healthworkers'] = $healthworkers;
        return $data;
    }
    /*---*/

    /*-- Requête pour récupérer le total des résultats retournés d'une recherche --*/
    public function getCountWorkersByFilters($get){
        $this->hydrate($get);
        $query = ' SELECT id FROM annuaire WHERE commune LIKE :commune AND civilite LIKE :civilite AND profession LIKE :profession AND nom_professionnel LIKE :nom_professionnel 
        AND nom_professionnel LIKE :prenom_professionnel AND mode_exercice LIKE :mode_exercice AND regroupement LIKE :regroupement AND nature_exercice LIKE :statut 
        AND departement LIKE :departement AND region LIKE :region';
        $result = $this->createQuery($query, [
            ':commune'=>$this->commune,
            ':civilite'=>$this->civilite,
            ':profession'=>$this->profession,
            ':nom_professionnel'=>'%'.$this->nom_professionnel.'%',
            ':prenom_professionnel' =>'%'.$this->prenom_professionnel.'%',
            ':regroupement' => $this->regroupement,
            ':statut' => $this->nature_exercice,
            ':mode_exercice' => $this->mode_exercice,
            ':departement' => $this->departement,
            ':region' => $this->region
        ]);
        $results = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = $this->dataPagination($results);
        return $data;
    }
    /*---*/

    /*-- Requête de recherche principale selon les données demandées --*/
    public function gethealthWorkersByFilters($get){
        $this->hydrate($get);
        $pagination = $this->getPagePagination();
        $sql = ' SELECT id, civilite, nom_professionnel, adresse, telephone, profession, coordonnees, commune, departement, region, contact, sesam_vital, convention_cacs, mode_exercice, nature_exercice, regroupement,
        type_acte_realise, acte_technique_realise, famille_acte_technique_realise, note, nb_notes, nb_comments FROM annuaire WHERE commune LIKE :commune AND civilite LIKE :civilite AND profession 
        LIKE :profession AND nom_professionnel LIKE :nom_professionnel AND nom_professionnel LIKE :prenom_professionnel AND mode_exercice LIKE :mode_exercice AND 
        regroupement LIKE :regroupement AND nature_exercice LIKE :statut AND departement LIKE :departement AND region LIKE :region ORDER BY nom_professionnel ASC';
        $sql.= ' LIMIT '.$pagination['limite'].' OFFSET '.$pagination['debut']; 
        $result = $this->createQuery($sql, [
            ':commune'=>$this->commune,
            ':civilite'=>$this->civilite,
            ':profession'=>$this->profession,
            ':nom_professionnel'=>'%'.$this->nom_professionnel.'%',
            ':prenom_professionnel' =>'%'.$this->prenom_professionnel.'%',
            ':regroupement' => $this->regroupement,
            ':statut' => $this->nature_exercice,
            ':mode_exercice' => $this->mode_exercice,
            ':departement' => $this->departement,
            ':region' => $this->region
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
        $query = 'SELECT coordonnees, contact, profession, nom_professionnel FROM annuaire 
        WHERE commune LIKE :commune AND civilite LIKE :civilite AND profession LIKE :profession AND nom_professionnel LIKE :nom_professionnel AND nom_professionnel LIKE :prenom_professionnel
        AND mode_exercice LIKE :mode_exercice AND regroupement LIKE :regroupement AND nature_exercice LIKE :statut AND departement LIKE :departement AND region LIKE :region ORDER BY nom_professionnel ASC';
        $query.= ' LIMIT '.$pagination['limite'].' OFFSET '.$pagination['debut']; 
        $dataQuery = $this->createQuery($query, [
            ':commune'=>$this->commune,
            ':civilite'=>$this->civilite,
            ':profession'=>$this->profession,
            ':nom_professionnel'=>'%'.$this->nom_professionnel.'%',
            ':prenom_professionnel' =>'%'.$this->prenom_professionnel.'%',
            ':regroupement' => $this->regroupement,
            ':statut' => $this->nature_exercice,
            ':mode_exercice' => $this->mode_exercice,
            ':departement' => $this->departement,
            ':region' => $this->region

        ]);
        $coordinates = $dataQuery->fetchAll(PDO::FETCH_ASSOC);
        return $coordinates;
    }

    /*-- Requête pour récupérer les éléments de recherches --*/
    public function getProfessions(){
        $sql = ' SELECT profession, COUNT(* ) FROM annuaire GROUP BY profession ORDER BY profession ASC';
        $result = $this->createQuery($sql);
        $professions = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = array();
        $data['success'] = true;
        $data['number'] = count($professions);
        $data['professions'] = $professions;
        return $data;
    }

    public function getGroupementsActs(){
        $sql = ' SELECT regroupement, COUNT(* ) FROM annuaire GROUP BY regroupement  ORDER BY regroupement ASC ';
        $result = $this->createQuery($sql);
        $groupementsActs = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = array();
        $data['success'] = true;
        $data['number'] = count($groupementsActs);
        $data['groupementsActs'] = $groupementsActs;
        return $data;
    }

    public function getModeExercices(){
        $sql = ' SELECT mode_exercice, COUNT(* ) FROM annuaire GROUP BY mode_exercice  ORDER BY mode_exercice ASC ';
        $result = $this->createQuery($sql);
        $modes_exercice = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = array();
        $data['success'] = true;
        $data['number'] = count($modes_exercice);
        $data['modes_exercice'] = $modes_exercice;
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

    public function getCities(){
        $sql = ' SELECT departement, COUNT(* ) FROM annuaire GROUP BY departement ';
        $result = $this->createQuery($sql);
        $cities = $result->fetchAll(PDO::FETCH_ASSOC);
        $data = array();
        $data['success'] = true;
        $data['number'] = count($cities);
        $data['departements'] = $cities;
        return $data;
    }
    /*---*/

    public function addRate($post){
        $sql = 'INSERT INTO rate (userId, workerId) VALUES (?, ?)';
        $this->createQuery($sql, [ $post['userId'], $post['workerId'] ]);
        $querySql = 'SELECT note, nb_notes FROM annuaire WHERE id = ?';
        $result = $this->createQuery($querySql, [$post['workerId']]);
        $actualRateofWorker = $result->fetch(PDO::FETCH_ASSOC);
        if ($actualRateofWorker['note'] != null){
            $nb_notes = intval($actualRateofWorker['nb_notes']) + 1;
            echo 'NB NOTES: '.$nb_notes;
            $rate = ($post['rate'] + intval($actualRateofWorker['note'])) / 2;
            $sql = 'UPDATE annuaire SET note = ?, nb_notes = ? WHERE id = ?';
            $this->createQuery($sql, [$rate, $nb_notes, $post['workerId']]);
            $data['rate'] = $rate;
            return $data;
        }
        else {
            $sql = 'UPDATE annuaire SET note = ?, nb_notes = ? WHERE id = ?';
            $this->createQuery($sql, [$post['rate'], 1, $post['workerId']]);
            $data['rate'] = $post['rate'];
            return $data;
        }
    }
}