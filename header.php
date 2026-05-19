<?php
// --- FICHIER : header.php ---
// --- ROLE : Header commun à toutes les pages, contient la navigation ---
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Vite & Gourmand</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        /* Design global du site */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #f8f9fa; }
        header { background: #000; padding: 20px 8%; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-family: 'Playfair Display', serif; color: #E85412; font-size: 1.5rem; font-weight: bold; }
        nav a { color: white; text-decoration: none; margin-left: 20px; font-size: 0.9rem; }
        .btn-orange { background: #E85412; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; }
    </style>
</head>
<body>
    <header>
        <div class="logo">🍴 Vite & Gourmand</div>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="menus.php">La Carte</a>
            <?php 
            // Gestion dynamique du lien de compte selon la session
            if (isset($_SESSION['user_id'])) {
                echo '<a href="deconnexion.php" style="color: #E85412; font-weight: bold;">Déconnexion</a>';
            } else {
                echo '<a href="connexion.php">Connexion</a>';
            }
            ?>
        </nav>
    </header>