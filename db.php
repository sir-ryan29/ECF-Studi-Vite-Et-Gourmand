<?php
// --- FICHIER : db.php ---
// --- ROLE : Connexion à la base de données et initialisation du schéma ---

$host = '127.0.0.1';
$dbname = 'vite_et_gourmand';
$username = 'root';
$password = '';

$pdo = null;

// 1. TENTATIVE DE CONNEXION MYSQL
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // 2. BACKUP SQLITE (Si MySQL échoue)
    if (extension_loaded('pdo_sqlite')) {
        $dataDirectory = __DIR__ . '/data';
        if (!is_dir($dataDirectory)) { mkdir($dataDirectory, 0777, true); }
        
        $pdo = new PDO('sqlite:' . $dataDirectory . '/vite_et_gourmand.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Initialisation de toutes les tables selon ton database.sql
        $pdo->exec('CREATE TABLE IF NOT EXISTS roles (id INTEGER PRIMARY KEY AUTOINCREMENT, nom_role TEXT NOT NULL)');
        $pdo->exec('CREATE TABLE IF NOT EXISTS utilisateur (id INTEGER PRIMARY KEY AUTOINCREMENT, nom TEXT, prenom TEXT, email TEXT UNIQUE, password TEXT, telephone TEXT, adresse_postale TEXT, id_role INTEGER DEFAULT 1, date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP)');
        $pdo->exec('CREATE TABLE IF NOT EXISTS theme (id INTEGER PRIMARY KEY AUTOINCREMENT, libelle TEXT)');
        $pdo->exec('CREATE TABLE IF NOT EXISTS regime (id INTEGER PRIMARY KEY AUTOINCREMENT, libelle TEXT)');
        $pdo->exec('CREATE TABLE IF NOT EXISTS menu (id INTEGER PRIMARY KEY AUTOINCREMENT, titre TEXT, description TEXT, nb_personne_min INTEGER, prix_par_personne_min REAL, stock_disponible INTEGER, id_theme INTEGER, id_regime INTEGER)');
        $pdo->exec('CREATE TABLE IF NOT EXISTS commande (id INTEGER PRIMARY KEY AUTOINCREMENT, id_client INTEGER, id_menu INTEGER, statut_commande TEXT DEFAULT "en attente", date_commande DATE, date_livraison DATE, heure_livraison TIME, lieu_livraison TEXT, nb_personnes INTEGER, prix_menu REAL, prix_livraison REAL, pret_materiel BOOLEAN DEFAULT 0, restitue_materiel BOOLEAN DEFAULT 0)');
    } else {
        die("Erreur : Impossible de se connecter à la base de données.");
    }
}
?>