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

$passwordUser = $conn->query("SELECT password
                            FROM utente 
                            WHERE nome_utente = '{$_SESSION['username']}' ");
$row = $passwordUser->fetch_assoc();
$password = $row['password'];

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
    
    
        <div id="accountContainer">
            <div id="aC_upper">
                <div id="aC_upper_image_section">
                    <img src="img/account_img.png">
                </div>
                <div id="aC_upper_data_section">
                    <h2>Nome</h2>
                    <input type="username" class="account_input_text" value="<?php echo $_SESSION['username']; ?>" readonly>
                    <h2>Password</h2>
                    <input type="password" class="account_input_text" value="<?php echo $password; ?>" readonly>                
                </div>
            </div>
            <div id="aC_lower">

            <div id="tabSelector">
                <button class="tabBtn active" data-target="sezioneFoto">LE TUE IMMAGINI</button>
                <button class="tabBtn" data-target="sezioneDownload">CRONOLOGIA DOWNLOAD</button>
                <button class="tabBtn" data-target="sezioneAggiunta">AGGIUNGI UN'IMMAGINE</button>
            </div>

            <div id="sezioneFoto" class="tabContent active">
                <h3>(Clicca su un'immagine per modificarla)</h3>
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
                <?php
                // Trasforma l'oggetto "mysqli_result" in varie stringhe tramite un FOR
                if ($downloadsUtente->num_rows > 0) {
                    while ($row = $downloadsUtente->fetch_assoc()) {
                        // "htmlspecialchars()" converte i caratteri speciali (<> " ') in encode HTML (&amp;, &quot;, &#039)
                        // >> Evita XSS (Cross-Site Scripting Attack)
                        $categoria = htmlspecialchars($row["nome_categoria"]);
                        $tag = htmlspecialchars($row["nome_tag"]);
                        $file = htmlspecialchars($row["nome_file"]);

                        echo "<img src='upload/$file'>";
                        // Togliere " data-categoria='$categoria' data-tag='$tag'" impediesce che l'immagine sia modificabile dall'utente
                    }
                } else {
                    echo "<h3> Non hai mai scaricato foto </h3>";
                }
                ?>
            </div>

            <div id="sezioneAggiunta" class="tabContent">
                <div id="modalFields">
                    <label>Nome dell'immagine:</label>
                    <input type="text" id="newImgName">

                    <label>File:</label>
                    <input type="file" id="newImgFile" name="newImgFile">


                    <label>Categoria:</label>
                    <select id="newImgCategoria">
                        <?php
                            while($categorie = $tutteCategorie->fetch_assoc()){
                                $nomeCat = htmlspecialchars($categorie["nome"]); // Prende il nome delle categorie

                                echo "<option value='$nomeCat'> $nomeCat </option>";
                            }
                        ?>
                    </select>

                    <label>Tag:</label>
                    <select id="newImgTag">
                        <?php
                            while($tags = $tuttiTag->fetch_assoc()){
                                $nomeTag = htmlspecialchars($tags["nome"]); // Prende il nome del tag

                                echo "<option value='$nomeTag'> $nomeTag </option>";
                            }
                        ?>
                    </select>

                    <div id="modalButtons">
                        <button id="addBtn">Aggiungi l'immagine al sito</button>
                    </div>
                </div>

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

            // Nasconde tutte le sezioni (non attive)
            tabContents.forEach(sec => sec.classList.remove("active"));

            // Mostra la sezione selezionata
            const target = document.getElementById(btn.dataset.target);
            target.classList.add("active");
        });
    });


    document.getElementById("addBtn").addEventListener("click", () => {
        if(confirm("Vuoi aggiungere l'immagine al sito con questi dati?")) {
            const nome_img = document.getElementById("newImgName").value;
            const file = document.getElementById("newImgFile").value;
            const categoria = document.getElementById("newImgCategoria").value;
            const tag = document.getElementById("newImgTag").value;
            
            // Crea un oggetto di tipo 'URLSearchParams' per inviare i dati
            const formData = new URLSearchParams();
            formData.append('nome_img', nome_img);
            formData.append('file', file);
            formData.append('categoria', categoria);
            formData.append('tag', tag);
            formData.append('action', "add");

            // [ Invio al file ]
            // >> Il fetch() invia una RICHIESTA ASINCRONA --> le risposte sono il .then()
            // >> 'body: formData' contiene il nome dell file da eliminare (vedi 3 righe sopra)
            fetch('photo_alteration_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text()) // Converte la risposta del server in Stringa
            .then(data => {
                // Esito e ridizionamento
                alert(data);
                window.location.href = "account.php";
            })
            .catch( err => {
                // Stampa eventuali errori nella console
                err => console.error(err)
            });

        } else {
            window.location.href = "account.php";
        }
    });



</script>

</html>