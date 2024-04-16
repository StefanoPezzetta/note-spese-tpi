<?php
session_start();
require("config.php"); //parametri di connessione
$mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
if ($mydb->connect_errno) {
    echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);
    
    if ($data !== null) {
        $id = $data["id"];
        $data = $data["data"];
        $descrizione = $data["descrizione"];
        $costo = $data["costo"];
        $stmt = $mydb->prepare("UPDATE nota SET data = ?, descrizione = ?, costo = ?  WHERE id = ?");
        $stmt->bind_param("ssdi",$data, $descrizione, $costo, $id);        
        $stmt->execute();
        $stmt->close();
    }
}
header("Location: home.php");