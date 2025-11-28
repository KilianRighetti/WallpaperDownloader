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

<script>
// Pulsante Elimina (solo commentato)
document.getElementById("deleteBtn").addEventListener("click", () => {
    if(confirm("Sei sicuro di voler eliminare questa immagine?")) {
        // Se elimina torna all'account

        alert("Funzione eliminazione commentata per sicurezza.");
    }
});

// Pulsante Salva modifiche
document.getElementById("saveBtn").addEventListener("click", () => {
    const categoria = document.getElementById("categoria").value;
    const tag = document.getElementById("tag").value;
    const file = '<?php echo $img['nome_file']; ?>';

    const formData = new URLSearchParams();
    formData.append('file', file);
    formData.append('categoria', categoria);
    formData.append('tag', tag);

    fetch('update_img.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        alert(data);
    })
    .catch(err => console.error(err));
});
</script>

</body>
</html>
