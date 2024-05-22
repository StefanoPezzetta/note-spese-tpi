<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica_nota</title>
    <link rel="stylesheet" href="modifica.css">

</head>
<body>
<div class="vertical-bar"></div>
<div class="content">
<h1 class="title"><span class="highlight">Spes</span>Hub</h1>
<hr class="separatore">
<div class="container">

<h2>Modifica nota</h2>
<img class="image" src="images/cartapenna.png">

<form action="home.modify.script.php" method="POST" id="formModificaNota" class="form-container">
<div class="contenutoForm">

        <input type="hidden" id="idNotaModifica" name="idNotaModifica">
        <input type="hidden" id="fkDescrizioneModifica" name="fkDescrizioneModifica">

        <select id="motivazioneModifica" name="motivazioneModifica" required>
            <option value="manutenzione">Manutenzione</option>
            <option value="convention">Convention</option>
            <option value="conferenza">Conferenza</option>
            <option value="trasporto">Trasporto</option>
            <option value="installazione">Installazione</option>
            <option value="sopralluogo">Sopralluogo</option>
            <option value="altro">Altro</option>
        </select><br>
        <select id="categoriaModifica" name="categoriaModifica" required>
            <option value="trasporto">Trasporto</option>
            <option value="alloggio">Alloggio</option>
            <option value="pasto">Pasto</option>
        </select><br>
        <select id="descrizioneModifica" name="descrizioneModifica" required>
        </select><br>
        <input type="number" id="costoModifica" name="costoModifica" placeholder=Costo><br>
        <input type="date" id="dataModifica" name="dataModifica"><br>
        </div>
        <button class="modifica" type="submit">Salva</button>  
    </form>
    <a class="indietro" href="home.php">Indietro</a>
    </div>
</div>
</body>
</html>
<script>
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
                 document.getElementById('costoModifica').value = costoDaModificare;
                 sottocategoria()
                 document.getElementById('descrizioneModifica').value = sottocategoriaDaModificare;
                 


                 if (result == 0) {
                    console.log("Il server ha restituito 0.");
                }
                
 
            } catch (error) {
                console.error('Errore nella fetch:', error.message);
            }

    }
    function sottocategoria(){
    const category = document.getElementById('categoriaModifica');
    const description = document.getElementById('descrizioneModifica');
    let selectedCategory = category.value;
        
    let optionsSottocategorie = [];
    if (selectedCategory === 'trasporto') {
            optionsSottocategorie = ['treno', 'metro', 'pullman', 'monopattino', 'taxi', 'noleggio', 'benzina', 'aereo', 'nave', 'traghetto', 'bicicletta'];
        } else if (selectedCategory === 'alloggio') {
            optionsSottocategorie = ['albergo', 'appartamento'];
        } else if (selectedCategory === 'pasto') {
            optionsSottocategorie = ['colazione', 'pranzo', 'cena'];
        }
        optionsSottocategorie.forEach(function(option) {
            const opt = document.createElement('option');
            opt.value = option.toLowerCase();
            opt.textContent = option;
            description.appendChild(opt);
        });
}
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
        
        if (selectedCategory === 'trasporto') {
            defaultOption.textContent = 'trasporto';
            options = ['treno', 'metro', 'pullman', 'monopattino', 'taxi', 'noleggio', 'benzina', 'aereo', 'nave', 'traghetto', 'bicicletta'];
        } else if (selectedCategory === 'alloggio') {
            defaultOption.textContent = 'alloggio';
            options = ['albergo', 'appartamento'];
        } else if (selectedCategory === 'pasto') {
            defaultOption.textContent = 'pasto';
            options = ['colazione', 'pranzo', 'cena'];
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
    getNotaDaModificare(); 

    const categorySelect = document.getElementById('categoriaModifica');
    const descriptionSelect = document.getElementById('descrizioneModifica');
    categorySelect.addEventListener('change', updateOptions);
    descriptionSelect.addEventListener('change', function() {
        console.log('Option selected in descriptionSelect');
        console.log(descriptionSelect.value);

        descriptionSelect.size = 1;
    });


   /*  document.addEventListener('DOMContentLoaded', function() {
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
               document.getElementById('costoModifica').value = costoDaModificare;
                 sottocategoria().then(() => {
                    document.getElementById('descrizioneModifica').value = sottocategoriaDaModificare;
                })


                 if (result == 0) {
                    console.log("Il server ha restituito 0.");
                }
                
 
            } catch (error) {
                console.error('Errore nella fetch:', error.message);
            }

    }
    getNotaDaModificare(); */
</script>