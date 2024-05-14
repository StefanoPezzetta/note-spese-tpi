<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="home.css">


</head>
<body>
    <div class="vertical-bar"></div>
    <div class="content">
    <h1 class="title"><span class="highlight">Spes</span>Hub</h1>
    <hr class="separatore">
    <a class="aggiungi" href="aggiungi.php">+ Nuovo</a>
    <h2>Note spese:</h2>
    <h3>Tutte</h3>
    <br>
    <button class="modifica" onclick='modificaNota()'><img src="images/modifica.png"/></button>
    <br>
    <button class="logout" onclick="logout()">Logout</button>

    <hr class="separatore">
    <h4 class="distanziate">
        <span>Motivazione</span>
        <span>Descrizione</span>
        <span>Data</span>
        <span>Costo</span>
    </h4>
    <div class="elementi" id="elementi"></div>
        <img class="filtra" src="images/filtro.png" onclick="filtraForm()" style="cursor:pointer; width: 1.5%;">
        <div id="formFiltraNota" class="hidden">
            <label for="data">Data inizio:</label> 
            <input type="date" id="dataInizio" name="dataInizio"><br>
            <label for="data">Data fine:</label>
            <input type="date" id="dataFine" name="dataFine"><br>
            <label for="motivazione">Motivazione:</label>
            <select id="motivazione" name="motivazione" required>
                <option value="" disabled selected>Seleziona una motivazione</option>
                <option value="manutenzione">Manutenzione</option>
                <option value="convention">Convention</option>
                <option value="conferenza">Conferenza</option>
                <option value="trasporto">Trasporto</option>
                <option value="installazione">Installazione</option>
                <option value="sopralluogo">Sopralluogo</option>
                <option value="altro">Altro</option>
            </select><br>
            <label for="categoria">Categoria:</label>
            <select id="categoria" name="categoria" required>
                <option value="" disabled selected>Seleziona una categoria</option>
                <option value="trasporto">Trasporto</option>
                <option value="alloggio">Alloggio</option>
                <option value="pasto">Pasto</option>
            </select><br>        
            <button onclick="filtraData(document.getElementById('dataInizio').value, document.getElementById('dataFine').value, document.getElementById('motivazione').value, document.getElementById('categoria').value)">Filtra</button>
            <button onclick="chiudiform()">Chiudi</button>
        </div>
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
    if(idDaModificare != ""){
        localStorage.setItem('idDaModificare', idDaModificare);

        window.location.href = 'modifica.php';
    }
    else{
        alert("Perfavore selezionare una nota da modificare");
    }


    
 }

 function chiudiform() {
    var element = document.getElementById("formFiltraNota");
    if (element) {
        element.classList.add('hidden');
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
    
    // Creazione dell'elemento principale della nota
    const elemento = document.createElement('div');
    elemento.classList.add('nota-element');
    
    // Creazione dell'ID utente con una classe CSS
    const idUtente = document.createElement('span');
    idUtente.classList.add('nota-id');
    idUtente.textContent = `ID Nota: ${nota.id}`;
    idUtente.hidden = true;  // Nasconde l'elemento


    // Creazione della motivazione con una classe CSS
    const motivazioneNota = document.createElement('span');
    motivazioneNota.classList.add('nota-motivazione');
    motivazioneNota.textContent = `${nota.motivazione}`;
    
    
    // Creazione della data con una classe CSS
    const dataNota = document.createElement('span');
    dataNota.classList.add('nota-data');
    dataNota.textContent = `${nota.data}`;
    
    
    // Creazione della descrizione con una classe CSS
    const descrizioneSottocategoriaNota = document.createElement('span');
    descrizioneSottocategoriaNota.classList.add('nota-descrizione-sottocategoria');
    descrizioneSottocategoriaNota.textContent = `${nota.descrizione}-${nota.sottocategoria}`;
    
    // Creazione della sottocategoria con una classe CSS
    /* const sottocategoriaNota = document.createElement('span');
    sottocategoriaNota.classList.add('nota-sottocategoria');
    sottocategoriaNota.textContent = `${nota.sottocategoria}`; */
    
    // Creazione del costo con una classe CSS
    const costoNota = document.createElement('span');
    costoNota.classList.add('nota-costo');
    costoNota.textContent = `€ ${nota.costo}`;
    
    // Creazione del checkbox associato all'elemento
    const checkbox = document.createElement('input');
    checkbox.type = 'checkbox';
    checkbox.classList.add('nota-checkbox');
    
    // Gestore di eventi per la selezione esclusiva di un solo checkbox
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            idDaModificare = nota.id;
            const checkboxes = document.querySelectorAll('#elementi input[type="checkbox"]');
            checkboxes.forEach(box => {
                if (box !== this) {
                    box.checked = false;
                }
            });
        }
    });

    const deleteImg = document.createElement('img');
deleteImg.src = 'images/cestino.png'; // Imposta il percorso effettivo dell'immagine di eliminazione
deleteImg.alt = 'Elimina'; // Testo alternativo per l'immagine
deleteImg.classList.add('delete-icon');

// Aggiungi un gestore di eventi al clic sull'immagine per eseguire la funzione deleteElement
deleteImg.addEventListener('click', function() {
    const confermaEliminazione = confirm("Stai per eliminare questa nota dall'elenco delle note spese, sei sicuro di voler procedere?");
    if(confermaEliminazione){
        deleteElement(nota.id);
    }
});

    // Aggiunta delle parti create all'elemento principale
    elemento.appendChild(idUtente);
    elemento.appendChild(checkbox);
    elemento.appendChild(motivazioneNota);
    elemento.appendChild(descrizioneSottocategoriaNota );
/*     elemento.appendChild(sottocategoriaNota);
 */    elemento.appendChild(dataNota);
    elemento.appendChild(costoNota);
    elemento.appendChild(deleteImg);
    
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

    function logout(){
        const confermaLogout = confirm("Sei sicuro di voler effettuare il logout?");
        // Specifica l'URL a cui vuoi inviare la richiesta GET
        if(confermaLogout){
            const url = 'logout.php';

        // Utilizza fetch per effettuare una richiesta GET all'URL specificato
        fetch(url)
        .then(response => {
            // Verifica se la risposta è ok (status code 200)
            if (response.ok) {
            console.log('Richiesta GET completata con successo');
            } else {
            // Se la risposta non è ok, lancia un errore
            throw new Error(`Errore nella richiesta: ${response.status}`);
            }
        })
        .catch(error => {
            // Gestisci eventuali errori
            console.error('Errore:', error);
        });
        window.location.href = 'index.php';
    }
    }

    async function filtraData(dataInizio, dataFine, motivazione, categoria) {
            const dataToSend = {
                dataInizio: dataInizio,
                dataFine:dataFine,
                motivazione:motivazione,
                categoria: categoria,
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



        function  deleteElement(id){
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
