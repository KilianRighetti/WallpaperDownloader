<?php 
include("config.php"); // esegue 
$tutteImmagini = $conn->query("SELECT nome_file FROM foto");
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
  <link rel="icon" href="images/general/Favicon.png" type="image/x-icon">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <!-- CSS Stylesheets and JavaScript-->
  <link rel="stylesheet" type="text/css" href="general_CSS.css">
  <script src="JavaScript.js" defer></script> <!-- 'defer' ensures scripts are executed after HTML is parsed -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">  
</head>
<body>

<div id="main">
    <!-- <div id="overlayDownload">
         a

    </div> -->

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
            <input type="text" id="uP_search_text" placeholder="Ricerca">
            <div id="uP_search_img">
                <img src="img/magnifying_glass.png">
            </div>
        </div>
        <input type="button" class="uP_button" id="buttonLogin" value="Login">
        <input type="button" class="uP_button" id="buttonRegistrati" value="Registrati">
    </div>

    <div id="lowerPart">
        <div id="lP_left">
            

        </div>
        <div id="lP_right">
            <h2> IMMAGINI </h2>

            <?php
                // Trasforma l'oggetto "mysqli_result" in varie stringhe tramite un FOR
                if ($tutteImmagini->num_rows > 0) {
                    while ($row = $tutteImmagini->fetch_assoc()) {
                        echo "<img src='upload/" . $row["nome_file"] . "'>";
                    }
                }
            ?>

        </div>



    </div>




</div>

</body> 
</html>