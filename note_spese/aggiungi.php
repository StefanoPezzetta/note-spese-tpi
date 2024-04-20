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
        <input type="text" id="descrizione" name="descrizione" required><br>
        <label for="costo">Costo:</label>
        <input type="number" id="costo" name="costo" required><br>
        <label for="data">Data:</label>
        <input type="date" id="data" name="data" required><br>
        <button type="submit">Aggiungi</button>
    </form>
</body>
</html>