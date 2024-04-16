<?php
session_start();
require("config.php"); //parametri di connessione
$mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
if ($mydb->connect_errno) {
    echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
    exit();
}

$descrizione = $_POST["descrizione"];
$costo = $_POST["costo"];
$data = $_POST["data"];
$user = $_SESSION["user"];
$stmt = $mydb->prepare("INSERT INTO nota(fkUtente, data, descrizione, costo) VALUES(?, ?, ?, ?)");
$stmt->bind_param("issd", $user, $data, $descrizione, $costo);
$stmt->execute();
$stmt->close();
header("Location: home.php");

