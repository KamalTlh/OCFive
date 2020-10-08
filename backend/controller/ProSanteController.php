<?php
namespace controller;

class ProSanteController extends Controller{

    // function jwt_request($token) {
    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //     CURLOPT_URL => "http://localhost/annuairesante/backend/index.php",
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_ENCODING => "",
    //     CURLOPT_MAXREDIRS => 10,
    //     CURLOPT_TIMEOUT => 0,
    //     CURLOPT_FOLLOWLOCATION => true,
    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     CURLOPT_CUSTOMREQUEST => "GET",
    //     CURLOPT_HTTPHEADER => array(
    //     "Authorization: Bearer eyJ0eciOiJSUzI1NiJ9.eyJMiIsInNjb3BlcyI6W119.K3lW1STQhMdxfAxn00E4WWFA3uN3iIA"
    //     ),
    //     ));

    //     $response = curl_exec($curl);
    //     $data = json_decode($response, true);

    //     var_dump($response);

    //     header('Content-Type: application/json'); // Specify the type of data
    //     $ch = curl_init('http://localhost/annuairesante/backend/index.php'); // Initialise cURL
    //     $authorization = "Authorization: Bearer ".$token; // Prepare the authorisation token
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization )); // Inject the token into the header
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_POST, 1); // Specify the request method as POST
    //     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
    //     $result = curl_exec($ch); // Execute the cURL statement
    //     curl_close($ch); // Close the cURL connection
    //     return json_decode($result); // Return the received data
 
    //  }

    public function getHealthWorkers($get){
        // $token = "9b90d5d8b1642db4dc3151853032ef18fa2d179d"; // Get your token from a cookie or database
        // $this->jwt_request($token);
        if($_GET['totalPages'] == 0){
            $data['page'] = $this->proSanteModel->getCountListWorkers();
        }
        $data['datas'] = $this->proSanteModel->getListHealthWorkers();
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }

    public function getHealthWorkerById($get){
        $data = $this->proSanteModel->getHealthWorkerById($get['id']);
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }

    public function getProfessions(){
        $data = $this->proSanteModel->getProfessions();
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }

    public function getGroupementsActs(){
        $data = $this->proSanteModel->getGroupementsActs();
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }
    
    public function getModeExercices(){
        $data = $this->proSanteModel->getModeExercices();
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }

    public function getRegions(){
        $data = $this->proSanteModel->getRegions();
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }

    public function getCities(){
        $data = $this->proSanteModel->getCities();
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }

    public function workersByFilters($get){
        if($_GET['totalPages'] == 0){
            $data['page'] = $this->proSanteModel->getCountWorkersByFilters($get);
        }
        $data['datas'] = $this->proSanteModel->gethealthWorkersByFilters($get);
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }

    public function addRate($post){
        if(isset($post['rate']) && isset($post['workerId'])){
            $data['rateAdded'] = $this->proSanteModel->addRate($post);
            return $this->view->render('JsonResponse',[
                'data'=> $data
            ]);
        }
        return $this->view->render('JsonResponse',[
            'data'=> 'Erreur lors du traitement des données. Veuillez réessayer plus tard.'
        ]);
    }
}