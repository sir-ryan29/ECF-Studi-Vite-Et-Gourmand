<?php
/**
 * FICHIER : actions/traitement_commande.php
 * ROLE : Enregistrement sécurisé de la commande en base de données.
 * SECURITE : Requête préparée contre les injections SQL.
 */
session_start();
require_once '../includes/db.php';

// Sécurité : accès réservé aux connectés
if (!isset($_SESSION['user_id'])) {
    header("Location: ../connexion.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_menu = $_POST['id_menu'];
    $date_livraison = $_POST['date_livraison'];
    $nb_personnes = $_POST['nb_personnes'];
    $lieu_livraison = $_POST['lieu_livraison'];
    $id_client = $_SESSION['user_id'];

    // Insertion avec marqueurs pour éviter les injections
    $sql = "INSERT INTO commande (id_client, id_menu, date_livraison, nb_personnes, lieu_livraison, statut_commande) 
            VALUES (?, ?, ?, ?, ?, 'En attente')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_client, $id_menu, $date_livraison, $nb_personnes, $lieu_livraison]);

    header("Location: ../espace_client.php?success=1");
    exit();
} else {
    header("Location: ../menus.php");
    exit();
}