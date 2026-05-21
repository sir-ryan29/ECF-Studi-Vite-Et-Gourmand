<?php
/**
 * FICHIER : includes/db.php
 * ROLE : Connexion à la base de données SQLite.
 * SECURITE : Utilisation de PDO avec gestion d'erreurs.
 */
try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/../data/vite_et_gourmand.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}