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
    
    $dataInizio = $data['dataInizio'];
    $dataFine = $data['dataFine'];
    $user = $_SESSION['user'];


    if ($dataInizio == null && $dataFine == null) {
        // Se entrambe le date sono nulle, esegui una query per recuperare tutte le note dell'utente
        $stmt = $mydb->prepare("SELECT id, data, descrizione, costo FROM nota WHERE fkUtente = ?");
        $stmt->bind_param("i", $user);
    } elseif ($dataFine != null && $dataInizio != null) {
        // Se entrambe le date sono specificate, esegui una query per recuperare le note nell'intervallo specificato
        $stmt = $mydb->prepare("SELECT id, data, descrizione, costo FROM nota WHERE fkUtente = ? AND data >= ? AND data <= ?");
        $stmt->bind_param("iss", $user, $dataInizio, $dataFine);
    } elseif ($dataFine != null) {
        // Se solo la dataFine è specificata, esegui una query per recuperare le note precedenti alla dataFine
        $stmt = $mydb->prepare("SELECT id, data, descrizione, costo FROM nota WHERE fkUtente = ? AND data <= ?");
        $stmt->bind_param("is", $user, $dataFine);
    } else {
        // Se solo la dataInizio è specificata, esegui una query per recuperare le note successive alla dataInizio
        $stmt = $mydb->prepare("SELECT id, data, descrizione, costo FROM nota WHERE fkUtente = ? AND data >= ?");
        $stmt->bind_param("is", $user, $dataInizio);
    }
    if ($stmt->execute()) {
        $stmt->bind_result($id, $data, $descrizione, $costo);
        while ($stmt->fetch()) {
            $result[] = [
                "id" => $id,
                "data" => $data,
                "descrizione" => $descrizione,
                "costo" => $costo,
            ];
        }
            
        $stmt->close();
    } 
}
if($result==null) {
$result=0;
}
$_SESSION['notes'] = $result;
echo json_encode($result);


