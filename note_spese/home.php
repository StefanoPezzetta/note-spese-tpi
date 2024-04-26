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

    <a href="aggiungi.php">Aggiungi nota</a>

        <button onclick='modificaNota()'>Modifica nota</button>




    <button onclick='filtraForm()'>Filtra</button>
    <div id = "formFiltraNota" class="hidden">
        <label for="data">Data inizio:</label> 
        <input type="date" id="dataInizio" name="dataInizio"><br>
        <label for="data">Data fine:</label>
        <input type="date" id="dataFine" name="dataFine"><br>
        <button onclick="filtraData(document.getElementById('dataInizio').value, document.getElementById('dataFine').value)">Filtra</button>
    </div>
        



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

    function modificaNota() {
    console.log(idDaModificare);

    localStorage.setItem('idDaModificare', idDaModificare);

    window.location.href = 'modifica.php';
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
        const elementiDiv = document.getElementById('elementi');

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
                .catch(elementiDiv.innerHTML = "non sono presenti note spese");
    }


    function createPage(notes) {
    if (notes === 0) {
        console.log("errore");
    } else {
        const elementiDiv = document.getElementById('elementi');
        elementiDiv.innerHTML = "";

        for (let i = 0; i < notes.length; i++) {
            const nota = notes[i];
            const elemento = document.createElement('div');
            elemento.textContent = `ID Utente: ${nota.id}, Data: ${nota.data}, Descrizione: ${nota.descrizione}, Costo: ${nota.costo}`;

            // Creazione del checkbox associato all'elemento
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            
            // Gestore di eventi per permettere la selezione esclusiva di un solo checkbox
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    // Deselect all other checkboxes
                    idDaModificare = nota.id;
                    const checkboxes = document.querySelectorAll('#elementi input[type="checkbox"]');
                    checkboxes.forEach(box => {
                        if (box !== this) {
                            box.checked = false;
                        }
                    });
                }
            });

            // Creazione del pulsante di eliminazione associato all'elemento
            const bottoneDelete = document.createElement('button');
            bottoneDelete.textContent = 'Elimina nota';
            bottoneDelete.addEventListener('click', function() {
                console.log(`${nota.id}`);
                console.log(`${nota.data}`);
                console.log(`${nota.descrizione}`);
                console.log(`${nota.costo}`);
                deleteElement(nota.id);
            });

            // Aggiunta del checkbox e del pulsante di eliminazione all'elemento
            elemento.appendChild(checkbox);
            elemento.appendChild(bottoneDelete);

            // Aggiunta dell'elemento al contenitore
            elementiDiv.appendChild(elemento);
        }
    }
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



        function    deleteElement(id){
            deleteDataFromServer(id).then(() => {
                getData();
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
