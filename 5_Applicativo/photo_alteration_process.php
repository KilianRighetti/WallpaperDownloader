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
            // $filePath = "./upload/" . $nomeFile;
            // if(file_exists($filePath)) {
            //     unlink($filePath);
            // }
            echo "Immagine eliminata con successo"; // Serve a far stampare un messaggio di successo nell'Alert
        } else {
            echo "Errore nell'eliminazione. Il file NON esiste.";
        }

    } else if ($action == 'update'){
        $nomeFile = $conn->real_escape_string($_POST['nome_file']);
        $nuovoNomeImg = $conn->real_escape_string($_POST['nome_img']);
        $nuovaCategoria = $conn->real_escape_string($_POST['categoria']);
        $nuovoTag = $conn->real_escape_string($_POST['tag']);

        echo "UPDATE foto
        SET nome='" . $nuovoNomeImg ."' ,  nome_categoria ='" . $nuovaCategoria ."', nome_tag= '". $nuovoTag ."'
        WHERE nome_file='" . $nomeFile ."' ";
        
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
        $file = $conn->real_escape_string($_POST['file']);
        $nomeImg = $conn->real_escape_string($_POST['nome_img']);
        $categoria = $conn->real_escape_string($_POST['categoria']);
        $tag = $conn->real_escape_string($_POST['tag']);
        
        // Query per AGGIORNARE dal DB
        $add = $conn->query("< QWERY >");

        if($add) {
            echo "Immagine aggiunta con successo";
        } else {
            echo "Errore nell'aggiunta dell'immagine.";
        }

    }
}
?>