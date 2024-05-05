<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGGIUNGI NOTA</title>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        // Selezione principale (categoria)
        const categorySelect = document.getElementById('categoria');
        // Selezione secondaria (descrizione)
        const descriptionSelect = document.getElementById('descrizione');
    
    function updateOptions() {
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

    </script>
</head>

<body>
    <form action="aggiungi.script.php" method="POST" id="aggiungiForm" class="hidden">
        <!-- Motivazione:-->
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

        <!-- Selezione principale: Categoria -->
        <label for="categoria">Categoria:</label>
        <select id="categoria" name="categoria" required>
            <option value="" disabled selected>Seleziona una categoria</option>
            <option value="trasporto">Trasporto</option>
            <option value="alloggio">Alloggio</option>
            <option value="pasto">Pasto</option>
        </select><br>

        <!-- Selezione secondaria: Descrizione -->
        <label for="descrizione">Descrizione:</label>
        <select id="descrizione" name="descrizione" required>
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
