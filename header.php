<?php
// --- FICHIER : header.php ---
// --- ROLE : En-tête dynamique avec gestion de session ---

// Démarrage de la session si ce n'est pas déjà fait
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Récupération du nom du fichier actuel pour gérer l'état "actif" des liens
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Vite & Gourmand</title>
</head>
<body>
<header>
    <a href="index.php" class="navbar-brand">Vite & Gourmand</a>
    
    <nav>
        <a href="index.php" class="<?= ($current_page == 'index.php') ? 'active' : '' ?>">Accueil</a>
        <a href="menus.php" class="<?= ($current_page == 'menus.php') ? 'active' : '' ?>">Menus</a>
        <a href="contact.php" class="<?= ($current_page == 'contact.php') ? 'active' : '' ?>">Contact</a>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="espace_client.php" class="<?= ($current_page == 'espace_client.php') ? 'active' : '' ?>">Mon Espace</a>
        <?php else: ?>
            <a href="connexion.php" class="<?= ($current_page == 'connexion.php') ? 'active' : '' ?>">Connexion</a>
        <?php endif; ?>
    </nav>
</header>