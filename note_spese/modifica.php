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
    <a href="home.php">Indietro</a>
</body>
</html>
<script>
    let idDaModificare = "";
    let dataDaModificare = "";
    let descrizioneDaModificare = "";
    let costoDaModificare = "";

    async function getNotaDaModificare(){
        idDaModificare = localStorage.getItem('idDaModificare');
        console.log(idDaModificare);

        const dataToSend = {
                id: idDaModificare,
            };
            console.log(dataToSend);

            try {
                const response = await fetch('getNotaDaModificare.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(dataToSend),
                });

                if (!response.ok) {
                    throw new Error(`Errore durante la richiesta al server. Codice di stato: ${response.status}`);
                }
                 const result = await response.json();
                 console.log(result);
                 dataDaModificare = result[0].data;
                 descrizioneDaModificare = result[0].descrizione;
                 costoDaModificare = result[0].costo;
                 console.log(dataDaModificare);
                 console.log(descrizioneDaModificare);
                 console.log(costoDaModificare);
                 console.log(idDaModificare);

                 document.getElementById('idNotaModifica').value = idDaModificare;
                 document.getElementById('dataModifica').value = dataDaModificare;
                 document.getElementById('descrizioneModifica').value = descrizioneDaModificare;
                 document.getElementById('costoModifica').value = costoDaModificare;


                 if (result == 0) {
                    // Gestisci il caso in cui il server restituisce 0
                    console.log("Il server ha restituito 0.");
                }
                
 
            } catch (error) {
                console.error('Errore nella fetch:', error.message);
            }

    }
    getNotaDaModificare();
</script>