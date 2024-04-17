<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div id="elementi"></div>

    <form action="aggiungi.script.php" method="POST" id="aggiungiForm" class="hidden">
        <label for="descrizione">Descrizione:</label>
        <input type="text" id="descrizione" name="descrizione" required><br>
        <label for="costo">Costo:</label>
        <input type="number" id="costo" name="costo" required><br>
        <label for="data">Data:</label>
        <input type="date" id="data" name="data" required><br>
        <button type="submit">Aggiungi</button>
    </form>
    <button id="mostraForm">Aggiungi nota</button>

    
    <form action="home.modify.script.php" method="POST" id="formModificaNota" class="hidden">
        <input type="text" id="idNotaModifica" name="idNotaModifica">
        <label for="descrizione">Descrizione:</label>
        <input type="text" id="descrizioneModifica" name="descrizioneModifica"><br>
        <label for="costo">Costo:</label>
        <input type="number" id="costoModifica" name="costoModifica"><br>
        <label for="data">Data:</label>
        <input type="date" id="dataModifica" name="dataModifica"><br>
        <button type="submit">Modifica</button>  
    </form>




    <button onclick='filtraNote'>Filtra</button>
    <form action="home.filter.script.php" method="POST" id="formModificaNota" class="hidden">
        <input type="number" id="costoModifica" name="costoModifica"><br>
        <label for="data">Data:</label> 
    </form>


<!-- 
    onclick="modifyElement(document.getElementById('idNotaModifica').value,
        document.getElementById('descrizioneModifica').value,
        document.getElementById('costoModifica').value,
        document.getElementById('dataModifica').value)" -->








    <script>
        let idDaModificare = "";
        async function deleteDataFromServer(id) {
            const dataToSend = {
                id: id,
            };
            console.log(dataToSend);

            try {
                const response = await fetch('home.delete.script.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(dataToSend),
                });

                if (!response.ok) {
                    throw new Error(`Errore durante la richiesta al server. Codice di stato: ${response.status}`);
                }
            } catch (error) {
                console.error('Errore nella fetch:', error.message);
            }
    }
    async function modifyElementFromServer(id, descrizione, costo, data) {
            const dataToSend = {
                id: id,
                descrizione: descrizione,
                costo: costo,
                data: data,
            };
            console.log(dataToSend);

            try {
                const response = await fetch('home.modify.script.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(dataToSend),
                });

                if (!response.ok) {
                    throw new Error(`Errore durante la richiesta al server. Codice di stato: ${response.status}`);
                }
            } catch (error) {
                console.error('Errore nella fetch:', error.message);
            }
    }
    async function createPage() {
    // Esegui una richiesta GET alla pagina PHP desiderata
            fetch('home.script.php')
                .then(response => response.json()) // Assicurati che la risposta sia in formato JSON
                .then(data => {
                    // Verifica se la richiesta è stata eseguita correttamente
                    if (data.hasOwnProperty('error')) {
                        // Se la richiesta ha restituito un errore, gestiscilo qui
                        console.error('Si è verificato un errore durante l\'esecuzione della query:', data.error);
                        return;
                    }

                    // Memorizza i dati ricevuti nella variabile notes
                    const notes = data;

                    // Ora puoi utilizzare la variabile notes per accedere ai dati ricevuti
                    console.log(notes); // Esempio di utilizzo: visualizza i dati nella console

                    // Creazione degli elementi HTML basati sui dati ricevuti
                    const elementiDiv = document.getElementById('elementi');
                    for (let i = 0; i < notes.length; i++) {
                        const nota = notes[i];
                        const elemento = document.createElement('div');
                        elemento.textContent = `ID Utente: ${nota.id}, Data: ${nota.data}, Descrizione: ${nota.descrizione}, Costo: ${nota.costo}`;

                        // Creazione del bottone associato all'elemento
                        const bottoneDelete = document.createElement('button');
                        const bottoneModify = document.createElement('button');
                        bottoneDelete.textContent = 'Elimina nota';
                        bottoneModify.textContent = 'Modifica nota';
                        // Aggiunta di un gestore di eventi per stampare l'ID dell'elemento quando il bottone viene cliccato
                        bottoneDelete.addEventListener('click', function() {
                            console.log(`${nota.id}`);
                            console.log(`${nota.data}`);
                            console.log(`${nota.descrizione}`);
                            console.log(`${nota.costo}`);
                            deleteElement(nota.id);
                        })
                        bottoneModify.addEventListener('click', function(){
                            console.log(`${nota.id}`);
                            console.log(`${nota.data}`);
                            console.log(`${nota.descrizione}`);
                            console.log(`${nota.costo}`); 
                            document.getElementById('formModificaNota').classList.remove('hidden');
                            document.getElementById('idNotaModifica').value = nota.id;
                            
                            // Inserisci i valori della nota nel form
                            idDaModificare = nota.id;
                            document.getElementById('descrizioneModifica').value = nota.descrizione;
                            document.getElementById('costoModifica').value = nota.costo;
                            document.getElementById('dataModifica').value = nota.data;

                        });

                        // Aggiunta dell'elemento e del bottone al contenitore
                        elemento.appendChild(bottoneDelete);
                        elemento.appendChild(bottoneModify);
                        elementiDiv.appendChild(elemento);
                    }
                })
                .catch(error => console.error('Si è verificato un errore:', error));
    }



    async function filtraNote(){
        const dataToSend = {
                data: data,
            };
            console.log(dataToSend);

            try {
                const response = await fetch('home.modify.script.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(dataToSend),
                });

                if (!response.ok) {
                    throw new Error(`Errore durante la richiesta al server. Codice di stato: ${response.status}`);
                }
            } catch (error) {
                console.error('Errore nella fetch:', error.message);
            }
    }





        document.getElementById('mostraForm').addEventListener('click', function() {
            document.getElementById('aggiungiForm').classList.remove('hidden');
            var today = new Date().toISOString().split('T')[0];
            document.getElementById('data').value = today;
        });

        document.getElementById('aggiungiForm').addEventListener('submit', function(event) {
            var descrizione = document.getElementById('descrizione').value;
            var costo = document.getElementById('costo').value;
            var data = document.getElementById('data').value;
            
            if (!descrizione || !costo || !data) {
                event.preventDefault(); // Impedisce l'invio del form se i campi obbligatori non sono stati compilati
                alert("Si prega di compilare tutti i campi obbligatori.");
            }
        });

        function deleteElement(id){
            deleteDataFromServer(id).then(() => {
                location.reload();
                                console.log('La richiesta di eliminazione è stata completata con successo.');
                                // Esegui altre azioni qui se necessario
                            })
                                .catch(error => {
                                    console.error('Si è verificato un errore durante l\'eliminazione:', error);
                            });
        }
        /* function modifyElement(id, descrizione, costo, data){
            console.log(id);
            console.log(descrizione);
            console.log(costo);
            console.log(data);
            modifyElementFromServer(id, descrizione, costo, data).then(() => {
                location.reload();
                                console.log('La richiesta di modifica è stata completata con successo.');
                                // Esegui altre azioni qui se necessario
                            })
                                .catch(error => {
                                    console.error('Si è verificato un errore durante l\'eliminazione:', error);
                            }); 
        } */
        window.addEventListener('DOMContentLoaded', createPage);

    </script>
</body>
</html>
