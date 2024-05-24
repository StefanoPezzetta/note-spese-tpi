<?php
session_start();
require("config.php"); // Parametri di connessione

// Connessione al database
$mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
if ($mydb->connect_errno) {
    header('Content-Type: application/json');
    echo json_encode(['error' => "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error]);
    exit();
}

// Controlla se la richiesta è POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leggi i dati JSON dall'input
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);

    // Controlla se i dati JSON sono stati letti correttamente
    if ($data !== null) {
        $email = $data["email"];
        $pw = $data["password"];

        // Prepara e esegui la query per trovare l'utente
        $stmt = $mydb->prepare("SELECT pw FROM utente WHERE email = ?");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $stmt->bind_result($hash);
            $stmt->fetch();
            $stmt->close();

            // Verifica se la password è corretta
            if ($hash !== null && password_verify($pw, $hash)) {
                // Recupera l'ID utente
                $stmt2 = $mydb->prepare("SELECT id FROM utente WHERE email = ?");
                $stmt2->bind_param("s", $email);
                $stmt2->execute();
                $stmt2->bind_result($user);
                $stmt2->fetch();
                $stmt2->close();

                // Imposta l'ID utente nella sessione
                $_SESSION["user"] = $user;

                // Risposta JSON di successo
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Accesso riuscito']);
            } else {
                // Risposta JSON per credenziali errate
                header('HTTP/1.1 401 Unauthorized');
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Credenziali di accesso non valide']);
            }
        } else {
            // Errore nell'esecuzione della query
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Errore interno del server']);
        }
    } else {
        // Se i dati JSON non sono stati letti correttamente
        header('HTTP/1.1 400 Bad Request');
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Richiesta non valida: dati JSON non corretti']);
    }
}

// Chiudi la connessione al database
$mydb->close();
