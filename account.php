<?php 
session_start(); // <-- SENZA QUESTO, $_SESSION è vuoto
include("config.php"); // esegue 

// [ PAGINA RISERVATA ]
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

$immaginiUtente = $conn->query("SELECT nome_file, nome_categoria, nome_tag
                               FROM foto
                               WHERE nome_autore = '{$_SESSION['username']}' ");
$downloadsUtente = $conn->query("SELECT nome_file, nome_categoria, nome_tag
                                FROM foto
                                LEFT JOIN downloads
                                ON foto.id = downloads.fk_idFoto
                                WHERE downloads.fk_utente = '{$_SESSION['username']}' ");
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
  <link rel="stylesheet" type="text/css" href="general_css.css">
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
                    [ Immagine default ] [Nome + password mostrate in input ]
            </div>
            <div id="aC_lower">

            <div id="tabSelector">
                <button class="tabBtn active" data-target="sezioneFoto">LE TUE FOTO</button>
                <button class="tabBtn" data-target="sezioneDownload">CRONOLOGIA DOWNLOAD</button>
            </div>

            <div id="sezioneFoto" class="tabContent active">

                <h2> LE TUE IMMAGINI </h2>
                <?php
                // Trasforma l'oggetto "mysqli_result" in varie stringhe tramite un FOR
                if ($immaginiUtente->num_rows > 0) {
                    while ($row = $immaginiUtente->fetch_assoc()) {
                        // "htmlspecialchars()" converte i caratteri speciali (<> " ') in encode HTML (&amp;, &quot;, &#039)
                        // >> Evita XSS (Cross-Site Scripting Attack)
                        $categoria = htmlspecialchars($row["nome_categoria"]);
                        $tag = htmlspecialchars($row["nome_tag"]);
                        $file = htmlspecialchars($row["nome_file"]);

                        echo "<img src='upload/$file' data-categoria='$categoria' data-tag='$tag'>";
                    }
                } else {
                    echo "<h3> Non hai caricato alcuna foto </h3>";
                }
                ?>
            </div>

            <div id="sezioneDownload" class="tabContent">

                <h2> CRONOLOGIA DOWNLOAD </h2>
                <?php
                // Trasforma l'oggetto "mysqli_result" in varie stringhe tramite un FOR
                if ($downloadsUtente->num_rows > 0) {
                    while ($row = $downloadsUtente->fetch_assoc()) {
                        // "htmlspecialchars()" converte i caratteri speciali (<> " ') in encode HTML (&amp;, &quot;, &#039)
                        // >> Evita XSS (Cross-Site Scripting Attack)
                        $categoria = htmlspecialchars($row["nome_categoria"]);
                        $tag = htmlspecialchars($row["nome_tag"]);
                        $file = htmlspecialchars($row["nome_file"]);

                        echo "<img src='upload/$file' data-categoria='$categoria' data-tag='$tag'>";
                    }
                } else {
                    echo "<h3> Non hai mai scaricato foto </h3>";
                }
                ?>
            </div>

        </div>
    </div>
</div>


</body>
<!-- [ Questa funzionalità va esgeuita alla fine per permettere ai componeneti HTML di generarsi  (altrimenti la lista containers è vuota) ] -->
<script>
    const tabButtons = document.querySelectorAll(".tabBtn");
    const tabContents = document.querySelectorAll(".tabContent");

    tabButtons.forEach(btn => {
        btn.addEventListener("click", () => {

            // Rimuovi classe active da tutti i bottoni
            tabButtons.forEach(b => b.classList.remove("active"));
            btn.classList.add("active");

            // Nascondi tutte le sezioni
            tabContents.forEach(sec => sec.classList.remove("active"));

            // Mostra la sezione selezionata
            const target = document.getElementById(btn.dataset.target);
            target.classList.add("active");
        });
    });
</script>

</html>