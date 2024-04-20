<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="home.modify.script.php" method="POST" id="formModificaNota" class="hidden">
        <input type="hidden" id="idNotaModifica" name="idNotaModifica">
        <label for="descrizione">Descrizione:</label>
        <input type="text" id="descrizioneModifica" name="descrizioneModifica"><br>
        <label for="costo">Costo:</label>
        <input type="number" id="costoModifica" name="costoModifica"><br>
        <label for="data">Data:</label>
        <input type="date" id="dataModifica" name="dataModifica"><br>
        <button type="submit">Modifica</button>  
    </form>
</body>
</html>