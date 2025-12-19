<?php
session_start(); // Serve per gestire il login tramite sessioni --> sempre per prima
include "config.php"; // Esegue il codice del file config.php 

$username = pulisci_input($_POST["username"]);
$password = pulisci_input($_POST["password"]);
$repeatedPassword = pulisci_input($_POST["repeatedPassword"]);

// [ PROCESSO DI ESTRAZIONE DAL DB ]
// ==> Per la spiegazione di questa parte di codice, guardare "login_process.php"
$sql = $conn->prepare("SELECT * FROM utente WHERE nome_utente = ?");
$sql->bind_param("s", $username);
$sql->execute();
$risultato = $sql->get_result();

if ($risultato->num_rows >= 1) {
    echo "<script>alert('Esiste già un utente con questo nome!'); window.location.href='register.php';</script>";
} else if($password != $repeatedPassword){
    echo "<script>alert('Le due password non coincidono.'); window.location.href='register.php';</script>";
} else {
    // {PARTE DI CODICE GENERATA DA CHATGPT, sistemata da me}
    // Crea un'HASH della password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT); // ------> da implementare

    // Inserimento nuovo utente
    $stmt = $conn->prepare("INSERT INTO utente (nome_utente, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    // Alert + Reindirizzamento a Login
    echo "<script>alert('Account creato!'); window.location.href='login.php';</script>";
    // {FINE DELLA PARTE GENERATA DA CHATGPT}
    header("Location: login.php");
    exit;
}

function pulisci_input($dato){
    $dato = ltrim($dato);
    $dato = rtrim($dato);
    return $dato;
}
?>