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
        <input type="hidden" id="fkDescrizioneModifica" name="fkDescrizioneModifica">

        <label for="motivazione">Motivazione:</label>
        <select id="motivazioneModifica" name="motivazioneModifica" required>
            <option value="manutenzione">Manutenzione</option>
            <option value="convention">Convention</option>
            <option value="conferenza">Conferenza</option>
            <option value="trasporto">Trasporto</option>
            <option value="installazione">Installazione</option>
            <option value="sopralluogo">Sopralluogo</option>
            <option value="altro">Altro</option>
        </select><br>
        <label for="categoria">Categoria:</label>
        <select id="categoriaModifica" name="categoriaModifica" required>
            <option value="Trasporto">Trasporto</option>
            <option value="Alloggio">Alloggio</option>
            <option value="Pasto">Pasto</option>
        </select><br>
        <label for="descrizione">Descrizione:</label>
        <select id="descrizioneModifica" name="descrizioneModifica" required>
        </select><br>
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
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('categoriaModifica');
        const descriptionSelect = document.getElementById('descrizioneModifica');
    
        function updateOptions() {
        descriptionSelect.innerHTML = '';
        
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.disabled = true;
        defaultOption.selected = true;
        defaultOption.textContent = '';
        descriptionSelect.appendChild(defaultOption);
        
        let selectedCategory = categorySelect.value;
        
        let options = [];
        
        let categoryLabel = '';
        
        if (selectedCategory === 'Trasporto') {
            defaultOption.textContent = 'Trasporto';
            options = ['Treno', 'Metro', 'Pullman', 'Monopattino', 'Taxi', 'Noleggio', 'Benzina', 'Aereo', 'Nave', 'Traghetto', 'Bicicletta'];
        } else if (selectedCategory === 'Alloggio') {
            defaultOption.textContent = 'Alloggio';
            options = ['Albergo', 'Appartamento'];
        } else if (selectedCategory === 'Pasto') {
            defaultOption.textContent = 'Pasto';
            options = ['Colazione', 'Pranzo', 'Cena'];
        }
        
    
        
        options.forEach(function(option) {
            const opt = document.createElement('option');
            opt.value = option.toLowerCase();
            opt.textContent = option;
            descriptionSelect.appendChild(opt);
            });
            
            descriptionSelect.focus();
            setTimeout(function() {
                setSelect(descriptionSelect, defaultOption);
            }, 100);
        }
        
        categorySelect.addEventListener('change', updateOptions);

        descriptionSelect.addEventListener('change', function() {
        console.log('Option selected in descriptionSelect');
        console.log(descriptionSelect.value);

        descriptionSelect.size = 1;
    });
 
}); 
function sottocategoria(){
    const category = document.getElementById('categoriaModifica');
    const description = document.getElementById('descrizioneModifica');
    let selectedCategory = category.value;
        
    let optionsSottocategorie = [];
    if (selectedCategory === 'Trasporto') {
            optionsSottocategorie = ['Treno', 'Metro', 'Pullman', 'Monopattino', 'Taxi', 'Noleggio', 'Benzina', 'Aereo', 'Nave', 'Traghetto', 'Bicicletta'];
        } else if (selectedCategory === 'Alloggio') {
            optionsSottocategorie = ['Albergo', 'Appartamento'];
        } else if (selectedCategory === 'Pasto') {
            optionsSottocategorie = ['Colazione', 'Pranzo', 'Cena'];
        }
        optionsSottocategorie.forEach(function(option) {
            const opt = document.createElement('option');
            opt.value = option.toLowerCase();
            opt.textContent = option;
            description.appendChild(opt);
        });
}
function setSelect(descriptionSelect, defaultOption) {
        if(defaultOption.textContent == "Trasporto"){
            console.log("trasporto");
            descriptionSelect.size = 1; 
            descriptionSelect.size = 5; 
        }else if(defaultOption.textContent == "Alloggio"){
            console.log("alloggio");
            descriptionSelect.size = 1; 
            descriptionSelect.size = 3; 
        }else{
            console.log("pasto");
            descriptionSelect.size = 1;
            descriptionSelect.size = 4; 
        }

}
















    let idDaModificare = "";
    let dataDaModificare = "";
    let motivazioneDaModificare = "";
    let descrizioneDaModificare = "";
    let sottocategoriaDaModificare = "";
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
                 fkDescrizioneDaModificare = result[0].fkDescrizione;
                 dataDaModificare = result[0].data;
                 motivazioneDaModificare = result[0].motivazione;
                 descrizioneDaModificare = result[0].descrizione;
                 sottocategoriaDaModificare = result[0].sottocategoria;
                 costoDaModificare = result[0].costo;
                 console.log(fkDescrizioneDaModificare);
                 console.log(dataDaModificare);
                 console.log(motivazioneDaModificare);
                 console.log(descrizioneDaModificare);
                 console.log(sottocategoriaDaModificare);
                 console.log(costoDaModificare);
                 console.log(idDaModificare);
                
                 document.getElementById('fkDescrizioneModifica').value = fkDescrizioneDaModificare;
                 document.getElementById('idNotaModifica').value = idDaModificare;
                 document.getElementById('dataModifica').value = dataDaModificare;
                 document.getElementById('motivazioneModifica').value = motivazioneDaModificare;
                 document.getElementById('categoriaModifica').value = descrizioneDaModificare;
/*                  document.getElementById('descrizioneModifica').value = sottocategoriaDaModificare;
 */              document.getElementById('costoModifica').value = costoDaModificare;
                 sottocategoria().then(() => {
                    // Esegui il codice commentato una volta che la promessa è stata risolta
                    document.getElementById('descrizioneModifica').value = sottocategoriaDaModificare;
                })


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