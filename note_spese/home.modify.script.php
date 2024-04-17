<?php
session_start();
require("config.php"); //parametri di connessione
$mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
if ($mydb->connect_errno) {
    echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
    exit();
}

$descrizione = $_POST["descrizioneModifica"];
$costo = $_POST["costoModifica"];
$data = $_POST["dataModifica"];
$id = $_POST["idNotaModifica"];
$stmt = $mydb->prepare("UPDATE nota SET data = ?, descrizione = ?, costo = ?  WHERE id = ?");
$stmt->bind_param("ssdi", $data, $descrizione, $costo, $id);
$stmt->execute();
$stmt->close();
header("Location: home.php");


/* "UPDATE nota SET data = ?, descrizione = ?, costo = ?  WHERE id = ?" */