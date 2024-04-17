<?php
session_start();
require("config.php");
$mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);

if ($mydb->connect_errno) {
    echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
    exit();
}

$email = $_POST["email"];
$pw = $_POST["pw"];
$nome = $_POST["nome"];
$cognome = $_POST["cognome"];

$hash = password_hash($pw, PASSWORD_DEFAULT);

$stmt = $mydb->prepare("SELECT * FROM utente WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

$num_rows = $result->num_rows;

$stmt->close();

if ($num_rows >= 1) {
    echo "cacca";
}else{
    $stmt2 = $mydb->prepare("INSERT INTO utente (email, pw, nome, cognome) VALUES (?, ?, ?, ?)");
    $stmt2->bind_param("ssss", $email, $hash, $nome, $cognome);
    $stmt2->execute();
    $stmt2->close(); 

    $stmt3 = $mydb->prepare("SELECT id FROM utente WHERE email = ?");
    $stmt3->bind_param("s", $email);
    if ($stmt3->execute()) {
        $stmt3->bind_result($user);
        $stmt3->fetch();
        $_SESSION["user"] = $user;
    }
    $stmt3->close();
    header("Location: home.php");

}
            


   
?>