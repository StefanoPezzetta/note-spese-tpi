<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGGIUNGI NOTA</title>
    <link rel="stylesheet" href="aggiungi.css">


</head>

<body>
<div class="vertical-bar"></div>
<div class="content">
<h1 class="title"><span class="highlight">Spes</span>Hub</h1>
<button onclick="logout()" >Logout</button>
    <hr class="separatore">
    <div class="container">
    <h2>Creazione nuova nota</h2>
    <img class="image" src="images/cartapenna.png">
    <form action="aggiungi.script.php" method="POST" id="aggiungiForm" class="form-container">
        <div class="contenutoForm">
            <!-- Selezione principale: Categoria -->
        <select id="categoria" name="categoria" required>
            <option value="" disabled selected>Descrizione</option>
            <option value="trasporto">Trasporto</option>
            <option value="alloggio">Alloggio</option>
            <option value="pasto">Pasto</option>
        </select><br>
        <!-- Selezione secondaria: Descrizione -->
        <select id="descrizione" name="descrizione" required class="hidden">
        </select><br>
        <input type="date" id="data" name="data" placeholder="Data" required><br>
        <!-- Motivazione:-->
        <select id="motivazione" name="motivazione" required>
            <option value="" disabled selected>Motivazione viaggio</option>
            <option value="manutenzione">Manutenzione</option>
            <option value="convention">Convention</option>
            <option value="conferenza">Conferenza</option>
            <option value="trasporto">Trasporto</option>
            <option value="installazione">Installazione</option>
            <option value="sopralluogo">Sopralluogo</option>
            <option value="altro">Altro</option>
        </select><br>
        <input type="number" id="costo" name="costo" placeholder="Costo" required><br>
   
        </div>

        <button class="crea" type="submit">Crea nota</button>

    </form>
    
    <a class="indietro" href="home.php">Indietro</a>
    </div>
</div>

</body>
</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Selezione principale (categoria)
    const categorySelect = document.getElementById('categoria');
        // Selezione secondaria (descrizione)
    const descriptionSelect = document.getElementById('descrizione');
    
    function updateOptions() {
    descriptionSelect.classList.remove('hidden');
    // Cancella le opzioni esistenti
    descriptionSelect.innerHTML = '';
    
    // Aggiungi l'opzione di selezione iniziale
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.disabled = true;
    defaultOption.selected = true;
    defaultOption.textContent = '';
    descriptionSelect.appendChild(defaultOption);
    
    // Ottieni la categoria selezionata
    const selectedCategory = categorySelect.value;
    
    // Opzioni da aggiungere
    let options = [];
    
    // Aggiungi l'opzione non selezionabile (voce di categoria) in base alla categoria selezionata
    let categoryLabel = '';
    
    if (selectedCategory === 'trasporto') {
        defaultOption.textContent = 'Trasporto';
        options = ['Treno', 'Metro', 'Pullman', 'Monopattino', 'Taxi', 'Noleggio', 'Benzina', 'Aereo', 'Nave', 'Traghetto', 'Bicicletta'];
    } else if (selectedCategory === 'alloggio') {
        defaultOption.textContent = 'Alloggio';
        options = ['Albergo', 'Appartamento'];
    } else if (selectedCategory === 'pasto') {
        defaultOption.textContent = 'Pasto';
        options = ['Colazione', 'Pranzo', 'Cena'];
    }
    
    // Aggiungi l'opzione non selezionabile (voce di categoria)
   
    
    // Aggiungi le nuove opzioni
    options.forEach(function(option) {
        const opt = document.createElement('option');
        opt.value = option.toLowerCase();
        opt.textContent = option;
        descriptionSelect.appendChild(opt);
        });
        
        // Porta a fuoco e cerca di aprire il menu a discesa
        descriptionSelect.focus();
        setTimeout(function() {
            setSelect(descriptionSelect, defaultOption);
        }, 100); // L'intervallo di tempo è di 100 millisecondi
    }
    
    categorySelect.addEventListener('change', updateOptions);

    // Gestore di eventi `change` su `descriptionSelect`
    descriptionSelect.addEventListener('change', function() {
    console.log('Option selected in descriptionSelect');
    console.log(descriptionSelect.value);

    // Rimuovi il focus da `descriptionSelect` quando viene selezionata un'opzione
    descriptionSelect.size = 1; // Reset la dimensione per assicurarsi che il menu a discesa si apra correttamente
});
 
});
function setSelect(descriptionSelect, defaultOption) {
        if(defaultOption.textContent == "Trasporto"){
            console.log("trasporto");
            descriptionSelect.size = 1; // Reset la dimensione per assicurarsi che il menu a discesa si apra correttamente
            descriptionSelect.size = 5; // Modifica la dimensione per far sì che il menu appaia più grande e l'utente veda più opzioni
        }else if(defaultOption.textContent == "Alloggio"){
            console.log("alloggio");
            descriptionSelect.size = 1; // Reset la dimensione per assicurarsi che il menu a discesa si apra correttamente
            descriptionSelect.size = 3; // Modifica la dimensione per far sì che il menu appaia più grande e l'utente veda più opzioni
        }else{
            console.log("pasto");
            descriptionSelect.size = 1; // Reset la dimensione per assicurarsi che il menu a discesa si apra correttamente
            descriptionSelect.size = 4; // Modifica la dimensione per far sì che il menu appaia più grande e l'utente veda più opzioni
        }

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

    </script>