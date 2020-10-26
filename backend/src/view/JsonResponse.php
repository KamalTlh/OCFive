<?php
$this->title = "Accueil";

header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: *');

$msgErreur=NULL;
$array['msg'] = $msgErreur;
$array['result'] = $data;

echo json_encode($data);
