<?php
// --- FICHIER : deconnexion.php ---
// --- ROLE : Fermeture sécurisée de la session utilisateur ---

// Initialisation de la session pour pouvoir y accéder
session_start();

// Suppression de toutes les variables de session en mémoire
session_unset();

// Destruction physique de la session sur le serveur
session_destroy();

// Redirection vers la page d'accueil après déconnexion
header("Location: index.php");
exit();
?>