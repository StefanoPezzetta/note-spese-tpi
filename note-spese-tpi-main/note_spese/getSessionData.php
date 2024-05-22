<?php
session_start();

$sessionData = $_SESSION['notes']; 

header('Content-Type: application/json');
echo json_encode($sessionData);
