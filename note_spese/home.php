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

    <!-- <form action="aggiungi.script.php" method="POST" id="aggiungiForm" class="hidden">
        <label for="descrizione">Descrizione:</label>
        <input type="text" id="descrizione" name="descrizione" required><br>
        <label for="costo">Costo:</label>
        <input type="number" id="costo" name="costo" required><br>
        <label for="data">Data:</label>
        <input type="date" id="data" name="data" required><br>
        <button type="submit">Aggiungi</button>
    </form> -->
<!--     <button id="mostraForm">Aggiungi nota</button>
 -->    <a href="aggiungi.php">Aggiungi nota</a>

        <a href="modifica.php"></a>
    <!-- <form action="home.modify.script.php" method="POST" id="formModificaNota" class="hidden">
        <input type="hidden" id="idNotaModifica" name="idNotaModifica">
        <label for="descrizione">Descrizione:</label>
        <input type="text" id="descrizioneModifica" name="descrizioneModifica"><br>
        <label for="costo">Costo:</label>
        <input type="number" id="costoModifica" name="costoModifica"><br>
        <label for="data">Data:</label>
        <input type="date" id="dataModifica" name="dataModifica"><br>
        <button type="submit">Modifica</button>  
    </form> -->




    <button onclick='filtraForm()'>Filtra</button>
    <div id = "formFiltraNota" class="hidden">
        <label for="data">Data inizio:</label> 
        <input type="date" id="dataInizio" name="dataInizio"><br>
        <label for="data">Data fine:</label>
        <input type="date" id="dataFine" name="dataFine"><br>
        <button onclick="filtraData(document.getElementById('dataInizio').value, document.getElementById('dataFine').value)">Filtra</button>
    </div>
        


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



    async function getData() {
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
                    let notes = data;

                    // Ora puoi utilizzare la variabile notes per accedere ai dati ricevuti
                    console.log(notes); // Esempio di utilizzo: visualizza i dati nella console

                    createPage(notes);
                })
                .catch(error => console.error('Si è verificato un errore:', error));
    }


    function createPage(notes){
        if(notes == 0){
            console.log("cacca");
        }
        // Creazione degli elementi HTML basati sui dati ricevuti
       else{ const elementiDiv = document.getElementById('elementi');
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
                        /* bottoneModify.addEventListener('click', function(){
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

                        }); */

                        // Aggiunta dell'elemento e del bottone al contenitore
                        elemento.appendChild(bottoneDelete);
                        elemento.appendChild(bottoneModify);
                        elementiDiv.appendChild(elemento);
                    }}
    }



    async function getSessionData(){
        fetch('getSessionData.php')
        .then(response => response.json())
        .then(data => {
            // Utilizza i dati ottenuti dalla sessione PHP
            console.log(data);
            createPage(data);
        })
        .catch(error => console.error('Errore durante il recupero dei dati della sessione:', error));
    }



    function filtraForm(){
        document.getElementById('formFiltraNota').classList.remove('hidden');
    }



    async function filtraData(dataInizio, dataFine) {
            const dataToSend = {
                dataInizio: dataInizio,
                dataFine:dataFine,
            };
            console.log(dataToSend);

            try {
                const response = await fetch('home.filter.script.php', {
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

                 if (result == 0) {
                    // Gestisci il caso in cui il server restituisce 0
                    console.log("Il server ha restituito 0.");
                }
                location.reload();
                
 
            } catch (error) {
                location.reload();  /* riguardala */
                console.error('Errore nella fetch:', error.message);
            }
    }






        /* document.getElementById('mostraForm').addEventListener('click', function() {
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
        }); */




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




        if (window.performance.navigation.type === window.performance.navigation.TYPE_RELOAD) {
            // La pagina è stata ricaricata
            getSessionData();
            console.log("La pagina è stata ricaricata");
        } else if (window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
            // È avvenuto uno spostamento da una pagina precedente o successiva
            getData();
            console.log("Spostamento da una pagina precedente o successiva");
        }else{
            getData();
            console.log("Navigazione normale");

        }
    </script>
</body>
</html>
