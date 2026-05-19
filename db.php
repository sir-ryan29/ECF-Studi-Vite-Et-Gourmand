<?php
// Fichier pour se connecter à la base de données
$host = 'localhost';
$dbname = 'vite_et_gourmand';
$username = 'root';
$password = '';

try {
    // Connexion avec PDO (comme appris en cours)
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Afficher les erreurs SQL pour nous aider au debug
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si la connexion échoue, on affiche un message d'erreur
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>