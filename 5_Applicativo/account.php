<?php 
session_start(); // <-- SENZA QUESTO, $_SESSION è vuoto
include("config.php"); // esegue 
$tutteImmagini = $conn->query("SELECT nome_file, nome_categoria, nome_tag FROM foto");
$tutteCategorie = $conn->query("SELECT nome FROM categoria");
$tuttiTag = $conn->query("SELECT nome FROM tag");
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <!-- Metadata -->
  <title>Wallpaper Downloader</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Sito sviluppato nel primo semestre 2025-2026 - M306 - Made by Kilian Righetti">
  <meta name="keywords" content="HTML, CSS, JS, PHP">
  <meta name="author" content="Kilian Righetti">
  <!-- Favicons and Icons -->
  <!-- <link rel="icon" href="images/general/Favicon.png" type="image/x-icon"> -->
  <!-- CSS Stylesheets and JavaScript-->
  <link rel="stylesheet" type="text/css" href="account_css.css">
  <script src="JavaScript.js"></script>
</head>
<body>

<div id="main">
    <div id="leftPart">
        <a href="index.php" class="goBack">
            🡸
        </a>    
        <img id="uP_logo" src="img/logo.png">
    </div>
    <div id="rightPart">
        <div id="accountContainer">
            <div id="aC_upper">
                
            </div>
        </div>
    </div>
</div>




</body>
<!-- [ Questa funzionalità va esgeuita alla fine per permettere ai componeneti HTML di generarsi  (altrimenti la lista containers è vuota) ] -->

<script>
// ChatGPT
function aggiornaImmagini() {
  const immagini = document.querySelectorAll('#lP_right img');

  immagini.forEach(img => {
      const cat = img.dataset.categoria;
      const tag = img.dataset.tag;

      // Mostra solo se corrisponde al filtro (categoria O tag)
      if((!filtroCategoria || filtroCategoria === cat) && (!filtroTag || filtroTag === tag)) {
        img.style.display = '';
      } else {
        img.style.display = 'none';
      }
  });
}


let filtroCategoria = null;
let filtroTag = null;

// Variabile che contiene tutti i containers della pagina:
// ==> In questo caso, 'Categorie' e 'Tags'
const containers = document.querySelectorAll('.lP_left_filterContainer');

containers.forEach(container => {
    const buttons = container.querySelectorAll('.lP_left_filterButton');

    // Ciclo che passa ogni bottone all'interno del contenitore
    buttons.forEach(button => {
        button.addEventListener('click', () => {
            // [ RACCOLTA dei valori ]
            const tipo = container.dataset.tipo; // Prende 'data-tipo="Categoria / Tags"' dal DIV dei conteiner
            const selectedValue = button.textContent; // Prende il nome contenuto nel button
            console.log(`Filtro selezionato: ${selectedValue}`);


            // [ GESTIONE del bottone attivo ]
            // >> Se il bottone era già attivo, lo disattivo e resetto il filtro...
            if(button.classList.contains('active')){
                button.classList.remove('active');
                if(tipo === "Categoria") filtroCategoria = null;
                else if(tipo === "Tags") filtroTag = null;
            // >> SE non era attivo, lo imposto come active
            } else {
                buttons.forEach(b => b.classList.remove('active')); // Toglie 'active' dagli altri bottoni nel container
                button.classList.add('active'); // Attiva SOLO il bottone cliccato
                // [ AGGIORNAMENTO del filtro ]
                if(tipo === "Categoria"){
                    filtroCategoria = selectedValue;
                } else if(tipo === "Tags"){
                    filtroTag = selectedValue;
                }
            }

            // Aggiorna le immagini
            aggiornaImmagini();
        });
    });
});


// [!!!!!!!!!!!!!!!!!!!!!!] --> C'ê un bug grafico quando ci sono poche immagini, si vede il body bianco


</script>



</html>