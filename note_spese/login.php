<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
<br><br><br>

<h1 class="title"><span class="bentornato">Bentornato su </span><span class="highlight">Spes</span>Hub</h1>
    <hr class="separatore">
    <div class="container">
    <h2>Accedi</h2>
    <br><br>    

    <a href="index.php" class="back-link">&#8592;</a>
    <a href="index.php">
    <img src="images/logo.png" alt="logo" class="logo" style="max-width: 40%; height: 40%;">
</a>


            <div class="form-group">
                <input type="text" id="email" placeholder="Email" name="email" required>
            </div>
            <div class="form-group">
                <input type="text" id="pw" placeholder="Password" name="pw" required>
            </div>
            <div id = "errore"></div>
            <div class="form-group">
            <a href="index.php" class="button">Indietro</a>
                <button onclick="login()">Login</button>
            </div>
        <div class="register-link">
            <p>Non hai un account? <a href="registrazione.php">Registrati</a></p>
        </div>
    </div>
</body>
</html>
<script>
async function login() {
    const email = document.getElementById('email').value;
    const password = document.getElementById('pw').value;
    const errore = document.getElementById('errore');

    
    const dataToSend = {
        email: email,
        password: password,
    };
    
    console.log(dataToSend);
    
    try {
        const response = await fetch('login.script.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(dataToSend),
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.error);
        }

        const data = await response.json();
        console.log('Accesso riuscito:', data);
        window.location.href = 'home.php'; // Reindirizza alla home page
    } catch (error) {
        console.error('Errore di autenticazione:', error.message);
        errore.innerHTML = "email o password errate";
    }
}
</script>
