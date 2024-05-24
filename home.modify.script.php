<?php
session_start();
require("config.php"); //parametri di connessione
$mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
if ($mydb->connect_errno) {
    echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
    exit();
}
$motivazione = $_POST["motivazioneModifica"];
$descrizione = $_POST["categoriaModifica"];
$sottocategoria = $_POST["descrizioneModifica"];
$costo = $_POST["costoModifica"];
$data = $_POST["dataModifica"];
$id = $_POST["idNotaModifica"];
$fkDescrizione = $_POST["fkDescrizioneModifica"];
$stmt = $mydb->prepare("UPDATE descrizione SET descrizione = ?, sottocategoria = ?  WHERE id = ?");
$stmt->bind_param("ssi", $descrizione, $sottocategoria, $fkDescrizione);
$stmt->execute();
$stmt->close();
$stmt2 = $mydb->prepare("UPDATE nota SET data = ?, costo = ?, motivazione = ?, fkDescrizione = ?  WHERE id = ?");
$stmt2->bind_param("sdsii", $data, $costo, $motivazione, $fkDescrizione, $id);
$stmt2->execute();
$stmt2->close();
header("Location: home.php");


/* "UPDATE nota SET data = ?, descrizione = ?, costo = ?  WHERE id = ?" */