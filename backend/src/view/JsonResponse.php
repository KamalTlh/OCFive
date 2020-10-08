<?php
$this->title = "Accueil";

// header('Content-Type: application/json');

header("Content-Type: application/json; charset=UTF_8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: *');
$msgErreur=NULL;
$array['msg'] = $msgErreur;
$array['result'] = $data;

echo json_encode($data);
