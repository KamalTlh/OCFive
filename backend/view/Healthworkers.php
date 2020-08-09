<?php
$this->title = "Accueil";

header('Content-Type: application/json');
$msgErreur=NULL;
$array['msg'] = $msgErreur;
$array['result'] = $data;
echo json_encode($data);
