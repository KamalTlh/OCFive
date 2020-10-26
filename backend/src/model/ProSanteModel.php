<?php
namespace MyApp\Model;
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
    private $sesam_vitale = '%';

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

    function getMode_exercice() { 
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
            // echo $method.'<br>';    
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

    public function deleteRatesUser($userId){
        $sql = 'DELETE FROM rate WHERE userId = ?';
        $this->createQuery($sql, [$userId]);
        $data['deleteRatesUser'] = true;
        return $data ;
    }
}