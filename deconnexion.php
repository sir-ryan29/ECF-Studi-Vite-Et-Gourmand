<?php
/**
 * FICHIER : deconnexion.php
 * ROLE : Fermeture sécurisée de la session utilisateur.
 */

// Initialisation de la session
session_start();

// Nettoyage et destruction de la session
session_unset();
session_destroy();

// Redirection vers la page d'accueil
header("Location: index.php");
exit();
?>