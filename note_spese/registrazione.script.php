<?php
session_start();
require("config.php");
$mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);

if ($mydb->connect_errno) {
    echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);

    if ($data !== null) {
        $email = $data["email"];
        $pw = $data["password"];
        $nome = $data["nome"];
        $cognome = $data["cognome"];
        
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $hash = password_hash($pw, PASSWORD_DEFAULT);

            $stmt = $mydb->prepare("SELECT * FROM utente WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();

            $result = $stmt->get_result();

            $num_rows = $result->num_rows;

            $stmt->close();

            if ($num_rows >= 1) {
                header('HTTP/1.1 409 Conflict');
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Email già in uso']);
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
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Accesso riuscito']);
            }
        } else {
            // L'email non è valida, gestisci l'errore
            // Risposta JSON per credenziali errate
            header('HTTP/1.1 400 Bad Request');
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Email non valida']);
        }

        
    }
}
            


   
?>