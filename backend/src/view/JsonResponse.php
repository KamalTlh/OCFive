<?php
$this->title = "Accueil";

// header('Content-Type: application/json');

// header("Content-Type: application/json; charset=UTF_8");
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET, POST');
// header('Access-Control-Allow-Headers: *');
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: *');
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$msgErreur=NULL;
$array['msg'] = $msgErreur;
$array['result'] = $data;

echo json_encode($data);
