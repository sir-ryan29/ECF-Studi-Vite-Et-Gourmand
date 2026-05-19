<?php
// On démarre la session pour pouvoir la détruire
session_start();

// On vide toutes les variables de session
session_unset();

// On détruit la session proprement
session_destroy();

// On redirige vers l'accueil
header("Location: index.php");
exit();
?>