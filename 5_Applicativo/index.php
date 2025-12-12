<?php 
session_start(); // <-- SENZA QUESTO, $_SESSION è vuoto
include("config.php"); // esegue 
$tutteImmagini = $conn->query("SELECT nome, nome_file, nome_categoria, nome_tag FROM foto");
$tutteCategorie = $conn->query("SELECT nome FROM categoria");
$tuttiTag = $conn->query("SELECT nome FROM tag");

// [ SEZIONE CON AJAX ]
// Quando la pagina riceve una richiesta POST (possibile solo con il download) ...
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['username'])){
    $receivedVariable = $_POST["nome_file"];

    // [ SEZIONE DI RACCOLTA DATI PER LA QUERY SQL]   
    //  >> "real_escape_string" crea una stringa SQL utilizzabile nelle query + lo pulisce
    $nomeFile = $conn->real_escape_string($_POST['nome_file']);

    // Trova l'ID dell'immagine scaricata a partire dal suo nome_file (ovvero url) --> È DI TIPO ARRAY
    $idImmagineSQL = $conn->query("SELECT id FROM foto WHERE nome_file='$nomeFile' ");
    // Converte in numero idImmagineSQL
    // >> Fetch_assoc()[] prende il valore dell'unica riga --> ["id" => 7]["id"]
    $idFoto = $idImmagineSQL->fetch_assoc()["id"];

    $utente = $_SESSION['username'];
    $ora = date("Y-m-d H:i:s"); 

    $conn->query("INSERT INTO downloads (fk_utente, fk_idFoto, data_ora)
                VALUES ('$utente', $idFoto, '$ora') ");
}
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
  <link rel="stylesheet" type="text/css" href="general_CSS.css">
  <script src="JavaScript.js"></script>
</head>
<body>

<div id="main">
    <!-- MODAL PER DOWNLOAD -->
    <div id="imageModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="modalImg">
        <div id="caption"></div>
        <button id="downloadBtn">Download</button>
    </div>

    <div id="upperPart">
        <img id="uP_logo" src="img/logo.png">
        <div id="uP_searchBarContainer">
            <input type="text" id="uP_search_text" placeholder="Ricerca per nome le immagini..." maxlength="30">
            <div id="uP_search_img">
                <img src="img/magnifying_glass.png">
            </div>
        </div>
        <?php if(isset($_SESSION['username'])){ // SE l'utente è loggato ?>
            <a href="account.php" id="uP_logged_username"> <?php echo $_SESSION['username']; ?> </a>
            <a class="uP_button" id="buttonLogout" href="logout_session.php" onclick="return confirm('Sei sicuro di effettuare il logout?');">Logout</a>
        <?php } else { ?>
            <a class="uP_button" id="buttonLogin" href="login.php">Login</a>
            <a class="uP_button" id="buttonRegistrati" href="register.php">Registrati</a>
        <?php } ?>
    </div>

    <div id="lowerPart">
        <div id="lP_left">
            <h1>Categoria</h1>
            <div class="lP_left_filterContainer" data-tipo="Categoria">
                <?php
                    // Ciclo per prendere tutte le categorie
                    if ($tutteCategorie->num_rows > 0) {
                        while ($row = $tutteCategorie->fetch_assoc()) {
                            echo "<button class='lP_left_filterButton'>" . $row["nome"] . "</button>";
                        }
                    }
                ?>
            </div>

            <h1>Tags</h1>
            <div class="lP_left_filterContainer" data-tipo="Tags">
                <?php
                    // Ciclo per prendere tutti i tag
                    if ($tuttiTag->num_rows > 0) {
                        while ($row = $tuttiTag->fetch_assoc()) {
                            echo "<button class='lP_left_filterButton'>" . $row["nome"] . "</button>";
                        }
                    }
                ?>
            </div>
        </div>

        <div id="lP_right">
            <h2 class="titoloSection">IMMAGINI</h2>
            <div id="imagesContainer">
                <?php
                    // Trasforma l'oggetto "mysqli_result" in varie stringhe tramite un FOR
                    if ($tutteImmagini->num_rows > 0) {
                        while ($row = $tutteImmagini->fetch_assoc()) {
                            // "htmlspecialchars()" converte i caratteri speciali (<> " ') in encode HTML (&amp;, &quot;, &#039)
                            // >> Evita XSS (Cross-Site Scripting Attack)
                            $categoria = htmlspecialchars($row["nome_categoria"]);
                            $tag = htmlspecialchars($row["nome_tag"]);
                            $file = htmlspecialchars($row["nome_file"]);
                            $nome = htmlspecialchars($row["nome"]);
                    
                            echo "<img src='upload/$file' data-categoria='$categoria' data-tag='$tag' data-nome='$nome'>";
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</div>

</body>
<!-- [ Questa funzionalità va esgeuita alla fine per permettere ai componeneti HTML di generarsi  (altrimenti la lista containers è vuota) ] -->

<script>
// Download dell'Immagine
downloadBtn.addEventListener("click", () => {
    const url = downloadBtn.getAttribute("data-url");
    const a = document.createElement("a");
    a.href = url;
    a.download = url.split("/").pop(); // Nome file automatico
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);

    // Richiama la funzione downloadImmagine passando il nome dell'immagine
    downloadImmagine(url);
});



// https://www.geeksforgeeks.org/php/how-to-pass-javascript-variables-to-php/ + ChatGPT
// {ChatGPT - Codice AJAX per permettere il download delle immagini tramite PHP}
function downloadImmagine() {
    const url = downloadBtn.getAttribute("data-url");
    const fileName = url.split("/").pop();

    // Dati da mandare a PHP (in forma "application/x-www-form-urlencoded")
    const dataToSend = "nome_file=" + encodeURIComponent(fileName);

    // [ Invio dei dati con AJAX ]
    const xhr = new XMLHttpRequest(); // Crea l'oggetto AJAX
    xhr.open("POST", "index.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.send(dataToSend);
}


// {ChatGPT}
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

function aggiornaImmaginiSearch(testoCercato){
    const immagini = document.querySelectorAll('#lP_right img');

    immagini.forEach(img => {
        const nome = img.dataset.nome.toLowerCase();

        if((nome.includes(testoCercato))) {
            img.style.display = '';
        } else if(nome === "" || nome === null || nome == undefined){ // SE la barra è vuota le mostra tutte
            img.style.display = '';
        }
        else {
            img.style.display = 'none';
        }
    });
}


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


uP_search_img.addEventListener("click", () => {
    aggiornaImmaginiSearch(document.getElementById("uP_search_text").value);
})
</script>
</html>