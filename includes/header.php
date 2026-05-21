<?php
/**
 * FICHIER : includes/header.php
 * ROLE : Navigation unifiée, logo officiel V&G et styles globaux.
 * DESIGN : Thème sombre, sobre et chic.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vite & Gourmand</title>
    
    <link rel="icon" type="image/png" href="assets/img/logo.png">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root { 
            --ocre: #d97706; 
            --white: #fff; 
            --dark: #111; 
        }
        body { 
            margin: 0; 
            font-family: 'Segoe UI', sans-serif; 
            background: #000; 
            color: #fff; 
        }
        header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 20px 8%; 
            background: #000; 
            border-bottom: 2px solid var(--ocre); 
        }
        .logo { 
            font-size: 1.6rem; 
            font-weight: bold; 
            color: var(--white); 
            text-decoration: none; 
            font-family: 'Playfair Display', serif; 
            display: flex; 
            align-items: center; 
            gap: 12px; 
        }
        .logo img { 
            height: 70px; 
            width: auto; 
            vertical-align: middle; 
            transition: transform 0.3s ease; 
        }
        .logo:hover img {
            transform: scale(1.05);
        }
        nav {
            display: flex;
            align-items: center;
        }
        nav a { 
            color: var(--white); 
            text-decoration: none; 
            margin-left: 25px; 
            font-weight: 500; 
        }
        nav a:hover { 
            color: var(--ocre); 
        }
        .btn-main { 
            background: var(--ocre); 
            padding: 10px 20px; 
            border-radius: 5px; 
            color: #fff !important; 
        }
    </style>
</head>
<body>

<header>
    <a href="index.php" class="logo">
        <img src="assets/img/logo.png" alt="Logo V&G">
        <span>Vite <span style="color: var(--ocre);">&</span> Gourmand</span>
    </a>

    <nav>
        <a href="index.php">Accueil</a>
        <a href="menus.php">Menus</a>
        <a href="offres.php">Offres</a>
        <a href="contact.php">Contact</a>
        
        <?php if (isset($_SESSION['user'])): ?>
            <a href="espace_client.php">Mon Espace</a>
            <a href="deconnexion.php" style="color: #ef4444;">Déconnexion</a>
        <?php else: ?>
            <a href="connexion.php">Connexion</a>
            <a href="inscription.php" class="btn-main">S'inscrire</a>
        <?php endif; ?>
    </nav>
</header>

<main>