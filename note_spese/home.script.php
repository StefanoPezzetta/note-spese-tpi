<?php
session_start();
require("config.php"); //parametri di connessione
$mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
if ($mydb->connect_errno) {
    echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
    exit();
}
$user = $_SESSION["user"];
$result = [];

$stmt_user = $mydb->prepare("SELECT nome, cognome FROM utente WHERE id = ?");
$stmt_user->bind_param("i", $user);
if ($stmt_user->execute()) {
    $stmt_user->bind_result($nome, $cognome);
    if ($stmt_user->fetch()) {
        $result['user'] = [
            "nome" => $nome,
            "cognome" => $cognome
        ];
    }
    $stmt_user->close();
} else {
    $result['error'] = "Errore durante l'esecuzione della query utente";
}
$stmt = $mydb->prepare("SELECT nota.id, nota.data, descrizione.descrizione, descrizione.sottocategoria, nota.costo , nota.motivazione FROM nota JOIN descrizione ON nota.fkDescrizione = descrizione.id WHERE nota.fkUtente = ?");
$stmt->bind_param("i", $user);
if ($stmt->execute()) {
    $stmt->bind_result($id, $data, $descrizione, $sottocategoria, $costo, $motivazione);

    while ($stmt->fetch()) {
        $result['notes'][] = [
            "id" => $id,
            "data" => $data,
            "descrizione" => $descrizione,
            "sottocategoria" => $sottocategoria,
            "costo" => $costo,
            "motivazione" => $motivazione,
        ];
    }
    $_SESSION['datiUtente'] = $result['user'];
    $_SESSION['notes'] = $result['notes'];
    $stmt->close();
} else {
    // Gestione degli errori durante l'esecuzione della query
    $result = [
        "error" => "Errore durante l'esecuzione della query"
    ];
}
echo json_encode($result);