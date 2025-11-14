<!-- File che serve a terminare la sessione quando necessario -->
<?php
session_start(); // APRE la sessione --> senza quetsa riga, non posso chiuderla
session_unset(); // Pulisce le variabili della sessione
session_destroy(); // Distrugge la sessione
header("Location: index.php"); // Ricarica la Home
exit;
?>
