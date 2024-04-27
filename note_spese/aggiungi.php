<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGGIUNGI NOTA</title>
</head>
<body>
<form action="aggiungi.script.php" method="POST" id="aggiungiForm" class="hidden">
        <label for="descrizione">Descrizione:</label>
        <select id="descrizione" name="descrizione" required>
            <!-- Opzione disabilitata (non selezionabile) -->
            <option value="" disabled selected>Seleziona una descrizione</option>
            <option value="treno">Treno</option>
            <option value="metro">Metro</option>
            <option value="pullman">Pullman</option>
            <option value="monopattino">Monopattino</option>
            <option value="taxi">Taxi</option>
            <option value="noleggio">Noleggio</option>
            <option value="benzina">Benzina</option>
            <option value="aereo">Aereo</option>
            <option value="nave">Nave</option>
            <option value="traghetto">Traghetto</option>
            <option value="bicicletta">Bicicletta</option>
        </select><br>

        <label for="costo">Costo:</label>
        <input type="number" id="costo" name="costo" required><br>
        
        <label for="data">Data:</label>
        <input type="date" id="data" name="data" required><br>
        
        <button type="submit">Aggiungi</button>
    </form>
    
    <a href="home.php">Indietro</a>
</body>
</html>