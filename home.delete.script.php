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
        $stmt = $mydb->prepare("SELECT fkDescrizione FROM nota WHERE id = ?");
        $stmt->bind_param("i", $id);        
        if($stmt->execute()){
            $stmt->bind_result($fkDescrizione);
            $stmt->fetch(); 

        }
        $stmt->close();

        

        $stmt3 = $mydb->prepare("DELETE FROM nota WHERE id = ?");
        $stmt3->bind_param("i", $id);        
        $stmt3->execute();
        $stmt3->close();

        $stmt2 = $mydb->prepare("DELETE FROM descrizione WHERE id = ?");
        $stmt2->bind_param("i", $fkDescrizione);        
        $stmt2->execute();
        $stmt2->close();
    }
}
header("Location: home.php");