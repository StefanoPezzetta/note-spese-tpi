<?php
session_start();
require("config.php"); //parametri di connessione
$mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
if ($mydb->connect_errno) {
    echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
    exit();
}

$descrizione = $_POST["categoria"];
$sottocategoria = $_POST["descrizione"];
$motivazione = $_POST["motivazione"];
$costo = $_POST["costo"];
$data = $_POST["data"];
$user = $_SESSION["user"];
$stmt = $mydb->prepare("INSERT INTO descrizione(descrizione, sottocategoria) VALUES(?, ?)");
$stmt->bind_param("ss", $descrizione, $sottocategoria);
$stmt->execute();
$stmt->close();
$stmt2 = $mydb->prepare("SELECT id FROM descrizione WHERE descrizione = ? AND sottocategoria = ?");
$stmt2->bind_param("ss", $descrizione, $sottocategoria);
if($stmt2->execute()){
    $stmt2->bind_result($id);
    $stmt2->fetch();
    $stmt2->close();    
}
$stmt3 = $mydb->prepare("INSERT INTO nota(fkUtente, data, costo, motivazione, fkDescrizione) VALUES(?, ?, ?, ?, ?)");
$stmt3->bind_param("isdsi", $user, $data, $costo, $motivazione, $id);
$stmt3->execute();
$stmt3->close();

header("Location: home.php");

