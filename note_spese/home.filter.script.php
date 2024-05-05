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

    if ($dataInizio === '' && $dataFine === '' && $motivazione === "" && $categoria === '') {
        // Condizione per tutte le note dell'utente 
        $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ?");
        $stmt->bind_param("i", $user);
    } elseif ($dataInizio === '' && $dataFine === '' && $motivazione !== '' && $categoria === '') {
        // Condizione per tutte le note dell'utente CON MOTIVAZIONE
        $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND nota.motivazione = ?");
        $stmt->bind_param("is", $user, $motivazione);
    } elseif ($dataInizio === '' && $dataFine === '' && $motivazione === '' && $categoria !== '') {
        // Condizione per le note dell'utente con una categoria specifica SENZA MOTIVAZIONE
        $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND descrizione.descrizione = ?");
        $stmt->bind_param("is", $user, $categoria);
    } elseif ($dataInizio === '' && $dataFine === '' && $motivazione !== '' && $categoria !== '') {
        // Condizione per le note dell'utente con una categoria specifica CON MOTIVAZIONE
        $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND nota.motivazione = ? AND descrizione.descrizione = ?");
        $stmt->bind_param("iss", $user, $motivazione, $categoria);
    } elseif ($dataInizio !== '' && $dataFine === ''  && $motivazione === '' && $categoria === '') {
        // Condizione per le note dell'utente con dataInizio SENZA MOTIVAZIONE
        $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND data >= ?");
        $stmt->bind_param("is", $user, $dataInizio);
        
    } elseif ($dataInizio !== '' && $dataFine === ''  && $motivazione !== '' && $categoria === '') {
        // Condizione per le note dell'utente con dataInizio CON MOTIVAZIONE
        $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND nota.motivazione = ? AND data >= ?");
        $stmt->bind_param("iss", $user, $motivazione, $dataInizio);
        
    } elseif ($dataInizio !== '' && $dataFine === '' && $motivazione === '' && $categoria !== '') {
        // Condizione per le note dell'utente con dataInizio e categoria specifica SENZA MOTIVAZIONE
        $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND descrizione.descrizione = ? AND data >= ?");
        $stmt->bind_param("iss", $user, $categoria, $dataInizio);
    } elseif ($dataInizio !== '' && $dataFine === '' && $motivazione !== '' && $categoria !== '') {
        // Condizione per le note dell'utente con dataInizio e categoria specifica CON MOTIVAZIONE
        $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND nota.motivazione = ? AND descrizione.descrizione = ? AND data >= ?");
        $stmt->bind_param("isss", $user, $motivazione, $categoria, $dataInizio);
    } elseif ($dataInizio === '' && $dataFine !== '' && $motivazione === '' && $categoria === '') {
        // Condizione per le note dell'utente con dataFine SENZA MOTIVAZIONE
        $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND data <= ?");
        $stmt->bind_param("is", $user, $dataFine);
    } elseif ($dataInizio === '' && $dataFine !== '' && $motivazione !== '' && $categoria === '') {
        // Condizione per le note dell'utente con dataFine CON MOTIVAZIONE
        $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND nota.motivazione = ? AND data <= ?");
        $stmt->bind_param("iss", $user, $motivazione, $dataFine);
    } elseif ($dataInizio === '' && $dataFine !== '' && $motivazione === '' && $categoria !== '') {
        // Condizione per le note dell'utente con dataFine e categoria specifica SENZA MOTIVAZIONE
        $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND descrizione.descrizione = ? AND data <= ?");
        $stmt->bind_param("iss", $user, $categoria, $dataFine);
    } elseif ($dataInizio === '' && $dataFine !== '' && $motivazione !== '' && $categoria !== '') {
        // Condizione per le note dell'utente con dataFine e categoria specifica CON MOTIVAZIONE
        $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND nota.motivazione = ? AND descrizione.descrizione = ? AND data <= ?");
        $stmt->bind_param("isss", $user, $motivazione, $categoria, $dataFine);
    }  elseif ($dataInizio !== '' && $dataFine !== '' && $motivazione === '' && $categoria === '') {
        // Condizione per le note dell'utente con un intervallo di date specifico SENZA MOTIVAZIONE
        $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND data >= ? AND data <= ?");
        $stmt->bind_param("iss", $user, $dataInizio, $dataFine);
    }elseif ($dataInizio !== '' && $dataFine !== '' && $motivazione !== '' && $categoria === '') {
        // Condizione per le note dell'utente con un intervallo di date specifico CON MOTIVAZIONE
        $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND nota.motivazione = ? AND data >= ? AND data <= ?");
        $stmt->bind_param("isss", $user, $motivazione, $dataInizio, $dataFine);
    } elseif ($dataInizio !== '' && $dataFine !== ''  && $motivazione === '' && $categoria !== '') {
        // Condizione per le note dell'utente con un intervallo di date e una categoria specifica SENZA MOTIVAZIONE
        $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ? AND descrizione.descrizione = ? AND data >= ? AND data <= ?");
        $stmt->bind_param("isss", $user, $categoria, $dataInizio, $dataFine);
    } elseif ($dataInizio !== '' && $dataFine !== ''  && $motivazione !== '' && $categoria !== '') {
        // Condizione per le note dell'utente con un intervallo di date e una categoria specifica CON MOTIVAZIONE
        $stmt = $mydb->prepare("SELECT nota.id, nota.data, nota.motivazione, descrizione.descrizione, descrizione.sottocategoria, nota.costo FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ?  AND nota.motivazione = ? AND descrizione.descrizione = ? AND data >= ? AND data <= ?");
        $stmt->bind_param("issss", $user,$motivazione, $categoria, $dataInizio, $dataFine);
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
