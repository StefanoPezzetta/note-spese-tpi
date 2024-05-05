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
        $stmt = $mydb->prepare("SELECT nota.data, nota.motivazione, nota.fkDescrizione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione on nota.fkDescrizione = descrizione.id WHERE nota.id = ?");
        $stmt->bind_param("i", $id); 
        if ($stmt->execute()) {
            $stmt->bind_result($data, $motivazione, $fkDescrizione, $descrizione, $sottocategoria, $costo);
        
            while ($stmt->fetch()) {
                $result[] = [
                    "data" => $data,
                    "motivazione" => $motivazione,
                    "fkDescrizione" => $fkDescrizione,
                    "descrizione" => $descrizione,
                    "sottocategoria" => $sottocategoria,
                    "costo" => $costo,
                ];
            }
            $stmt->close();
        } else {
            // Gestione degli errori durante l'esecuzione della query
            $result = [
                "error" => "Errore durante l'esecuzione della query"
            ];
        }
    }
}
echo json_encode($result);