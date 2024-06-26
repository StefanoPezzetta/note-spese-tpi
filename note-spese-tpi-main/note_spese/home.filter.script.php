<?php
session_start();
require("config.php"); // Parametri di connessione

$mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
if ($mydb->connect_errno) {
    echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
    exit();
}

$result = []; // Inizializza l'array `result`

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);
    
    $dataInizio = isset($data['dataInizio']) ? $data['dataInizio'] : '';
    $dataFine = isset($data['dataFine']) ? $data['dataFine'] : '';
    $motivazione = isset($data['motivazione']) ? $data['motivazione'] : '';
    $categoria = isset($data['categoria']) ? $data['categoria'] : '';
    $user = $_SESSION['user'];
    
    $stmt = null;
    $sqlQuery = "";

    switch(true) {
        case $dataInizio === '' && $dataFine === '' && $motivazione === "" && $categoria === '':
            $sqlQuery = "SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ?";
            $stmt = $mydb->prepare($sqlQuery);
            $stmt->bind_param("i", $user);
            break;
        case $dataInizio === '' && $dataFine === '' && $motivazione !== '' && $categoria === '':
            $sqlQuery = "SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND nota.motivazione = ?";
            $stmt = $mydb->prepare($sqlQuery);
            $stmt->bind_param("is", $user, $motivazione);
            break;
        case $dataInizio === '' && $dataFine === '' && $motivazione === '' && $categoria !== '';
            // Condizione per le note dell'utente con una categoria specifica SENZA MOTIVAZIONE
            $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND descrizione.descrizione = ?");
            $stmt->bind_param("is", $user, $categoria);
            break;
        case $dataInizio === '' && $dataFine === '' && $motivazione !== '' && $categoria !== '';
            // Condizione per le note dell'utente con una categoria specifica CON MOTIVAZIONE
            $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND nota.motivazione = ? AND descrizione.descrizione = ?");
            $stmt->bind_param("iss", $user, $motivazione, $categoria);
            break;
        case $dataInizio !== '' && $dataFine === ''  && $motivazione === '' && $categoria === '';
            // Condizione per le note dell'utente con dataInizio SENZA MOTIVAZIONE
            $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND data >= ?");
            $stmt->bind_param("is", $user, $dataInizio);
            break;
        case $dataInizio !== '' && $dataFine === ''  && $motivazione !== '' && $categoria === '';
            // Condizione per le note dell'utente con dataInizio CON MOTIVAZIONE
            $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND nota.motivazione = ? AND data >= ?");
            $stmt->bind_param("iss", $user, $motivazione, $dataInizio);
            break;
        case $dataInizio !== '' && $dataFine === '' && $motivazione === '' && $categoria !== '';
            // Condizione per le note dell'utente con dataInizio CON MOTIVAZIONE
            $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND nota.motivazione = ? AND data >= ?");
            $stmt->bind_param("iss", $user, $motivazione, $dataInizio);
            break;
            
        case $dataInizio !== '' && $dataFine === '' && $motivazione !== '' && $categoria !== '';
            // Condizione per le note dell'utente con dataInizio e categoria specifica CON MOTIVAZIONE
            $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND nota.motivazione = ? AND descrizione.descrizione = ? AND data >= ?");
            $stmt->bind_param("isss", $user, $motivazione, $categoria, $dataInizio);
            break;
        case $dataInizio === '' && $dataFine !== '' && $motivazione === '' && $categoria === '';
            // Condizione per le note dell'utente con dataFine SENZA MOTIVAZIONE
            $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND data <= ?");
            $stmt->bind_param("is", $user, $dataFine);
            break;
        case $dataInizio === '' && $dataFine !== '' && $motivazione !== '' && $categoria === '';
            // Condizione per le note dell'utente con dataFine CON MOTIVAZIONE
            $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND nota.motivazione = ? AND data <= ?");
            $stmt->bind_param("iss", $user, $motivazione, $dataFine);
            break;
        case $dataInizio === '' && $dataFine !== '' && $motivazione === '' && $categoria !== '';
            // Condizione per le note dell'utente con dataFine e categoria specifica SENZA MOTIVAZIONE
            $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND descrizione.descrizione = ? AND data <= ?");
            $stmt->bind_param("iss", $user, $categoria, $dataFine);
            break;
        case $dataInizio === '' && $dataFine !== '' && $motivazione !== '' && $categoria !== '';
            // Condizione per le note dell'utente con dataFine e categoria specifica CON MOTIVAZIONE
            $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND nota.motivazione = ? AND descrizione.descrizione = ? AND data <= ?");
            $stmt->bind_param("isss", $user, $motivazione, $categoria, $dataFine);
            break;
        case $dataInizio !== '' && $dataFine !== '' && $motivazione === '' && $categoria === '';
            // Condizione per le note dell'utente con un intervallo di date specifico SENZA MOTIVAZIONE
            $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND data >= ? AND data <= ?");
            $stmt->bind_param("iss", $user, $dataInizio, $dataFine);
            break;
        case $dataInizio !== '' && $dataFine !== '' && $motivazione !== '' && $categoria === '';
            // Condizione per le note dell'utente con un intervallo di date specifico CON MOTIVAZIONE
            $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND nota.motivazione = ? AND data >= ? AND data <= ?");
            $stmt->bind_param("isss", $user, $motivazione, $dataInizio, $dataFine);
            break;
        case $dataInizio !== '' && $dataFine !== ''  && $motivazione === '' && $categoria !== '';
            // Condizione per le note dell'utente con un intervallo di date e una categoria specifica SENZA MOTIVAZIONE
            $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND descrizione.descrizione = ? AND data >= ? AND data <= ?");
            $stmt->bind_param("isss", $user, $categoria, $dataInizio, $dataFine);
            break;
        case $dataInizio !== '' && $dataFine !== ''  && $motivazione !== '' && $categoria !== '';
            // Condizione per le note dell'utente con un intervallo di date e una categoria specifica CON MOTIVAZIONE
            $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ?  AND nota.motivazione = ? AND descrizione.descrizione = ? AND data >= ? AND data <= ?");
            $stmt->bind_param("issss", $user,$motivazione, $categoria, $dataInizio, $dataFine);
            break;  
        default:
            echo("errore");
        break;
    } 

   
    if ($stmt && $stmt->execute()) {
        $stmt->bind_result($id, $data, $motivazione, $descrizione, $sottocategoria, $costo);
        while ($stmt->fetch()) {
            $result[] = [
                'id' => $id,
                'data' => $data,
                'motivazione' => $motivazione,
                'descrizione' => $descrizione,
                'sottocategoria' => $sottocategoria,
                'costo' => $costo,
            ];
        }
        $stmt->close();
    } else {
        // Gestisci eventuali errori nell'esecuzione della query
        error_log('Errore nell\'esecuzione della query: ' . ($stmt ? $stmt->error : 'Errore di connessione'));
    }
}

// Assegna il risultato alla sessione
$_SESSION['notes'] = $result;

// Restituisci il risultato come JSON
echo json_encode($result);

// Chiudi la connessione al database
$mydb->close();
?>
