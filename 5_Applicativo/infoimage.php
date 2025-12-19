<?php
session_start();
include("config.php");

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "GET"){
    $receivedVariable = $conn->real_escape_string($_GET["nome_file"]); // Evita SQL_Injection

    // >> "real_escape_string" crea una stringa SQL utilizzabile nelle query + lo pulisce
    $nomeFile = $conn->real_escape_string($_GET['nome_file']);

    // Recupera informazioni immagine
    $result = $conn->query("SELECT id, nome, nome_file, nome_categoria, nome_tag 
                        FROM foto 
                        WHERE nome_file='$receivedVariable'");
    
    if ($result->num_rows === 0) {
        die("Immagine non trovata.");
    }

    $img = $result->fetch_assoc();

    // Prende tutte le categorie e tag
    $tutteCategorie = $conn->query("SELECT nome FROM categoria ORDER BY (nome = '".$img['nome_categoria']."' ) DESC, nome ASC");
    $tuttiTag = $conn->query("SELECT nome FROM tag ORDER BY (nome = '".$img['nome_tag']."') DESC");
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Modifica Immagine</title>

<!-- CSS Stylesheets and JavaScript-->
<link rel="stylesheet" type="text/css" href="general_css.css">
<link rel="stylesheet" type="text/css" href="account_css.css">
<script src="JavaScript.js"></script>
</head>


<body>
    <div id="leftPart">
        <a href="account.php" class="goBack">
            🡸
        </a>
        <img id="uP_logo" src="img/logo.png">
    </div>


    <div id="rightPart">
        <!-- MODAL PER MODIFICA FOTO -->
        <div id="modalInner">
            <img src="<?php echo "./upload/" . $nomeFile ?>">

            <div id="modalFields">
                <label>Nome:</label>
                <input type="text" id="imgName" value="<?php echo $img['nome'] ?>">

                <label>Categoria:</label>
                <select id="imgCategoria">
                    <?php
                        while($categorie = $tutteCategorie->fetch_assoc()){
                            $nomeCat = htmlspecialchars($categorie["nome"]); // Prende il nome delle categorie

                            echo "<option value='$nomeCat'> $nomeCat </option>";
                        }
                    ?>
                </select>

                <label>Tag:</label>
                <select id="imgTag">
                    <?php
                        while($tags = $tuttiTag->fetch_assoc()){
                            $nomeTag = htmlspecialchars($tags["nome"]); // Prende il nome del tag

                            echo "<option value='$nomeTag'> $nomeTag </option>";
                        }
                    ?>
                </select>

                <div id="modalButtons">
                    <button id="saveBtn">Salva modifiche</button>
                    <button id="deleteBtn">Elimina immagine</button>
                </div>
            </div>
        </div>
    </div>

</body>


<script>
    // [ Pulsante Elimina ]
    // {ChatGPT - Tranne l'action ed i commenti aggiunti da me}
    document.getElementById("deleteBtn").addEventListener("click", () => {
        if(confirm("Sei sicuro di voler eliminare questa immagine?")) {
            const nome_file = '<?php echo $img['nome_file']; ?>';
            // Crea un oggetto di tipo 'URLSearchParams' per inviare i dati
            const formData = new URLSearchParams();
            formData.append('nome_file', nome_file);
            formData.append('action', "delete");

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
        }
    });


    // [ Pulsante Salva modifiche ]
    // [!!!] NOTA: Questa sezione di codice è  identica alla precedente, non la commento per questa ragione
    document.getElementById("saveBtn").addEventListener("click", () => {
        const categoria = document.getElementById("imgCategoria").value;
        const tag = document.getElementById("imgTag").value;
        const nome_img = document.getElementById("imgName").value;
        const nome_file = '<?php echo $img['nome_file']; ?>';

        const formData = new URLSearchParams();
        formData.append('nome_img', nome_img);
        formData.append('nome_file', nome_file);
        formData.append('categoria', categoria);
        formData.append('tag', tag);
        formData.append('action', "update");


        fetch('photo_alteration_process.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            alert(data);
            window.location.href = "account.php";
        })
        .catch( err => {
            err => console.error(err)
        });
    });
</script>
</html>