<?php
session_start(); // Serve per gestire il login tramite sessioni --> sempre per prima
include "config.php"; // Esegue il codice del file config.php 

$username = pulisci_input($_POST["username"]);
$password = pulisci_input($_POST["password"]);

// [ PROCESSO DI ESTRAZIONE DAL DB ]
$sql = $conn->prepare("SELECT * FROM utente WHERE nome_utente = ?");
  // >> Il "?" rappresenta il Charachter Binding che ho visto a Java, serve a proteggere da SQL_Injection
$sql->bind_param("s", $username);
  // bind_param(): BINDING del parametro "?"
  // >> s: Sta per Stringa
  // >> $username: il valore da inserire al posto del "?"
$sql->execute();
$risultato = $sql->get_result();

// { Siccome ho degli utenti del DB con password non hashate, ChatGPT mi ha generato la logica che HASHA le password non salvate }
// { Le parti generate in questa sezione iniziano e terminano con un "{ChatGPT}"}

if ($risultato->num_rows == 1) {
    $utente = $risultato->fetch_assoc(); // Estrazione della riga trovata
      // >> fetch_assoc(): Estrae la riga come ARRAY ASSOCIATIVO (chiave/valore)

    // {ChatGPT} Controlla se la password nel DB è già hashata
    if (password_needs_rehash($utente['password'], PASSWORD_DEFAULT)) {
        // Se NON è hashata, verifica in CHIARO
        if ($password === $utente['password']) {
            $_SESSION['username'] = $utente['nome_utente'];

            // [ PROCESSO DI HASHING ]
            // $newHash = password_hash($password, PASSWORD_DEFAULT);
            // $update = $conn->prepare("UPDATE utente SET password=? WHERE nome_utente=?");
            // $update->bind_param("ss", $newHash, $utente['nome_utente']);
            // $update->execute();

            // Reindirizzamento a index.php
            header("Location: index.php");
            exit;
        }
        // {ChatGPT}
    }
    // if($password === $utente["password"]) { // ==> VERSIONE SENZA HASH
    if(password_verify($password, $utente["password"])) { // ==> VERSIONE CON HASH
        // Login corretto
        $_SESSION["username"] = $utente["nome_utente"];

        // Reindirizzamento alla homepage
        header("Location: index.php"); 
        echo "<script>alert('LOGIN RIUSCITO');</script>";
        exit;
    } else {
        echo "<script>alert('Credenziali errate'); window.location.href='login.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Credenziali errate'); window.location.href='login.php';</script>";
}


function pulisci_input($dato){
    $dato = ltrim($dato);
    $dato = rtrim($dato);
    return $dato;
}
?>