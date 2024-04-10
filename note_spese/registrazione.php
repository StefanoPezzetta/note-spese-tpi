<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
</head>
<body>
    <div class="container">
        <h2>Registrazione</h2>
        <form action="registrazione.script.php" method="POST">
            <div class="form-group">
                <label for="username">Nome:</label>
                <input type="text" id="nome" name="nome" required>
                <br>
                <label for="username">Cognome:</label>
                <input type="text" id="cognome" name="cognome" required>
                <br>
                <label for="username">Email:</label>
                <input type="text" id="email" name="email" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" id="pw" name="pw" required>
            </div>
            <!-- <div class="form-group">
                <label for="confirm_password">Conferma Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div> -->
            <div class="form-group">
                <button type="submit">Registrati</button>
            </div>
        </form>
    </div>
</body>
</html>
