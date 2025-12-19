<?php
session_start();
include("config.php");

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}


if($_SERVER['REQUEST_METHOD'] === 'POST') { // Richiesta che arriva dal pulsante 'dltButton'
    $action = $_POST['action'];

    if($action == 'delete'){
        $nomeFile = $conn->real_escape_string($_POST['nome_file']);
        // Query per eliminare dal DB
        $delete = $conn->query("DELETE FROM foto WHERE nome_file='$nomeFile'");
    
        if($delete) {
            // Cancella il file fisico
            $filePath = "./upload/" . $nomeFile;
            if(file_exists($filePath)) {
                unlink($filePath);
            }
            echo "Immagine eliminata con successo"; // Serve a far stampare un messaggio di successo nell'Alert
        } else {
            echo "Errore nell'eliminazione. Il file NON esiste.";
        }

    } else if ($action == 'update'){
        $nomeFile = $conn->real_escape_string($_POST['nome_file']);
        $nuovoNomeImg = $conn->real_escape_string($_POST['nome_img']);
        $nuovaCategoria = $conn->real_escape_string($_POST['categoria']);
        $nuovoTag = $conn->real_escape_string($_POST['tag']);

        // Query per AGGIORNARE dal DB
        $update = $conn->query("UPDATE foto
                                SET nome='" . $nuovoNomeImg ."' ,  nome_categoria ='" . $nuovaCategoria ."', nome_tag= '". $nuovoTag ."'
                                WHERE nome_file='" . $nomeFile ."' ");

        if($update) {
            echo "Immagine modificata con successo";
        } else {
            echo "Errore nell'aggirnamento. Valori non validi.";
        }

    } else if ($action == 'add'){
        $nomeImg = $conn->real_escape_string($_POST['nome_img']);
        $autore = $_SESSION['username'];
        $categoria = $conn->real_escape_string($_POST['categoria']);
        $tag = $conn->real_escape_string($_POST['tag']);
        // Estensioni consentite
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Gestione file upload
        $fileTmp = $_FILES['file']['tmp_name']; // $_FILES viene riempita con il formData() di account.php
        $fileName = basename($_FILES['file']['name']);
        $fileDest = "upload/" . $fileName;

        // controllo estensione
        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "Formato NON valido. Sono ammessi solo JPG, PNG e WEBP.";
            exit;
        }

        // Echo del file:
        // echo "1] TMP: $fileTmp<br>";
        // echo "2] NAME: $fileName<br>";
        // echo "3] DEST: $fileDest<br>";

        // Salvataggio immagine
        if(!file_exists($fileDest)) { // Se l'immagine ha un nome univoco...
            move_uploaded_file($fileTmp, $fileDest);
        } else {
            echo "Errore, esiste un'immagine con lo stesso nome";
            exit;
        }

        // Dimensioni immagine
        $dimensioniImg = getimagesize($fileDest);
        $larghezza = $dimensioniImg[0];
        $altezza   = $dimensioniImg[1];

        $add = $conn->query("INSERT INTO foto (nome, nome_file, nome_autore, nome_categoria, nome_tag, larghezza, altezza)
                VALUES ('$nomeImg', '$fileName', '$autore', '$categoria', '$tag', '$larghezza', '$altezza')");

        echo $add;

        if($add) {
            echo "Immagine aggiunta con successo";
        } else {
            echo "Errore nell'aggiunta dell'immagine.";
        }

    }
}
?>