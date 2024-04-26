<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
    <link rel="stylesheet" href="registrazione.css">
</head>
<body>
    <br><br><br>
    <h1 class="title">Benvenuto su <span class="highlight">Spes</span>Hub</h1>
    <hr class="separatore">

    <div class="container">
    <a href="index.php" class="back-link">&#8592;</a>

    <a href="index.php">
    <img src="images/logo.png" alt="logo" class="logo" style="max-width: 30%; height: 30%;">
</a>



        <h2>Registrazione</h2>
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
                <br>
                <label for="cognome">Cognome:</label>
                <input type="text" id="cognome" name="cognome" required>
                <br>
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required>
                <br>
                <label for="pw">Password:</label>
                <input type="password" id="pw" name="pw" required>
            </div>
            <div id = "errore" ></div>
            <div class="form-group">
                <button onclick = registrati()>Registrati</button>
            </div>
            <p>Sei già un utente? <a href="login.php">Accedi</a></p>

    </div>
</body>
</html>
<script>
    async function registrati() {
    const email = document.getElementById('email').value;
    const password = document.getElementById('pw').value;
    const nome = document.getElementById('nome').value;
    const cognome = document.getElementById('cognome').value;
    const errore = document.getElementById('errore');

    
    const dataToSend = {
        email: email,
        password: password,
        nome: nome,
        cognome: cognome,
    };

try {
    // Effettua la richiesta HTTP POST al server
    const response = await fetch('registrazione.script.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(dataToSend),
    });

    if (!response.ok) {
        // Leggi la risposta JSON
        const errorData = await response.json();

        // Controlla il codice di stato HTTP
        if (response.status === 400) {
            // Errore 400: Bad Request (email non valida)
            errore.innerHTML = 'Email non valida. Inserire mail valida.';
        } else if (response.status === 409) {
            // Errore 409: Conflict (email già in uso)
            errore.innerHTML = 'Email già in uso. Per favore, utilizza un\'altra email.';
        } else {
            // Altri errori (ad esempio, 500 Internal Server Error)
            errore.innerHTML = 'Si è verificato un errore. Per favore, riprova.';
        }

        // Lancia un'eccezione con il messaggio di errore
        throw new Error(errorData.error);
    }

    // Ottieni la risposta JSON
    const data = await response.json();

    // Gestisci il successo (accesso riuscito)
    if (data.success) {
        window.location.href = 'home.php';
    } else {
        errore.innerHTML = 'Operazione fallita, per favore riprova.';
    }
} catch (error) {
    // Mostra il messaggio di errore all'utente
    errore.innerHTML = error.message;
}
}

</script>
