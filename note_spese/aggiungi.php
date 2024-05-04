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
    
    // Funzione per aggiornare le opzioni della selezione secondaria
    function updateOptions() {
        // Cancella le opzioni esistenti
        descriptionSelect.innerHTML = '';
        
        // Aggiungi l'opzione di selezione iniziale
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.disabled = true;
        defaultOption.selected = true;
        defaultOption.textContent = 'Seleziona una descrizione';
        descriptionSelect.appendChild(defaultOption);
        
        // Ottieni la categoria selezionata
        const selectedCategory = categorySelect.value;
        
        // Opzioni da aggiungere
        let options = [];
        
        // Aggiungi opzioni in base alla categoria selezionata
        if (selectedCategory === 'trasporto') {
            options = ['Treno', 'Metro', 'Pullman', 'Monopattino', 'Taxi', 'Noleggio', 'Benzina', 'Aereo', 'Nave', 'Traghetto', 'Bicicletta'];
        } else if (selectedCategory === 'alloggio') {
            options = ['Hotel', 'B&B', 'Airbnb', 'Ostello', 'Casa vacanze'];
        } else if (selectedCategory === 'viaggio') {
            options = ['Agenzia di viaggi', 'Viaggio organizzato', 'Tour privato', 'Crociere'];
        }
        
        // Aggiungi le nuove opzioni
        options.forEach(function(option) {
            const opt = document.createElement('option');
            opt.value = option.toLowerCase();
            opt.textContent = option;
            descriptionSelect.appendChild(opt);
        });
        
        // Porta a fuoco e cerca di aprire il menu a discesa
        descriptionSelect.focus();
        // Aggiungi eventualmente un timeout per permettere al focus di essere stabilito
        setTimeout(() => {
            descriptionSelect.size = 1; // Reset la dimensione per assicurarsi che il menu a discesa si apra correttamente
            descriptionSelect.size = 10; // Modifica la dimensione per far sì che il menu appaia più grande e l'utente veda più opzioni
        }, 10);
    }
    
    // Aggiungi gestore di eventi alla selezione principale
    categorySelect.addEventListener('change', updateOptions);
});

    </script>
</head>

<body>
    <form action="aggiungi.script.php" method="POST" id="aggiungiForm" class="hidden">
        <!-- Selezione principale: Categoria -->
        <label for="categoria">Categoria:</label>
        <select id="categoria" name="categoria" required>
            <option value="" disabled selected>Seleziona una categoria</option>
            <option value="trasporto">Trasporto</option>
            <option value="alloggio">Alloggio</option>
            <option value="viaggio">Viaggio</option>
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
