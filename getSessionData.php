<?php
session_start();
$sessionData = [];
$sessionData['notes'] = $_SESSION['notes']; 
$sessionData['user'] = $_SESSION['datiUtente'];

header('Content-Type: application/json');
echo json_encode($sessionData);
