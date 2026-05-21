<?php
// --- FICHIER : traitement_commande.php ---
// --- ROLE : Enregistrement de la commande en base de données ---

session_start();
require_once 'db.php';

// Vérification sécurité : utilisateur connecté ?
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

// Vérification : formulaire bien envoyé en POST ?
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_menu = $_POST['id_menu'];
    $date_livraison = $_POST['date_livraison'];
    $nb_personnes = $_POST['nb_personnes'];
    $lieu_livraison = $_POST['lieu_livraison'];
    $id_client = $_SESSION['user_id'];

    // Insertion sécurisée dans la table commande
    $stmt = $pdo->prepare("INSERT INTO commande (id_client, id_menu, date_livraison, nb_personnes, lieu_livraison, statut_commande) VALUES (?, ?, ?, ?, ?, 'En attente')");
    $stmt->execute([$id_client, $id_menu, $date_livraison, $nb_personnes, $lieu_livraison]);

    // Redirection vers l'espace client pour voir la confirmation
    header("Location: espace_client.php?success=1");
    exit();
} else {
    header("Location: menus.php");
    exit();
}
?>