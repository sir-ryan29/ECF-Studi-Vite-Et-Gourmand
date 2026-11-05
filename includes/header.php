<?php
/**
 * FICHIER : includes/header.php
 * ROLE : En-tête global, barre de navigation dynamique et gestion de la session.
 */

// Initialisation de la session si elle n'est pas encore active
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
    
    <!-- Favicon et FontAwesome -->
    <link rel="icon" type="image/png" href="assets/img/others/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Styles globaux et variables de thème -->
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
            transition: color 0.3s ease;
        }
        
        nav a:hover { 
            color: var(--ocre); 
        }
        
        .btn-main { 
            background: var(--ocre); 
            padding: 10px 20px; 
            border-radius: 5px; 
            color: #fff !important; 
            font-weight: bold;
            transition: background 0.3s ease;
        }
        
        .btn-main:hover {
            background: #e68208;
        }
        
        .user-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--ocre);
            font-weight: bold;
            padding: 8px 14px;
            background: rgba(217, 119, 6, 0.1);
            border: 1px solid var(--ocre);
            border-radius: 20px;
            margin-left: 25px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .user-badge:hover {
            background: var(--ocre);
            color: #fff;
        }
        
        .btn-logout {
            color: #ef4444 !important;
            margin-left: 15px;
            font-size: 0.9rem;
        }
        
        .btn-logout:hover {
            color: #f87171 !important;
        }
    </style>
</head>
<body>

<header>
    <!-- Logo principal avec image de secours -->
    <a href="index.php" class="logo">
        <img src="assets/img/others/logo.png" alt="Logo V&G" onerror="this.onerror=null; this.src='assets/img/logo.png';">
        <span>Vite <span style="color: var(--ocre);">&</span> Gourmand</span>
    </a>

    <!-- Navigation principale dynamique selon la session -->
    <nav>
        <a href="index.php">Accueil</a>
        <a href="menus.php">Menus</a>
        <a href="offres.php">Offres</a>
        <a href="contact.php">Contact</a>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Liens si l'utilisateur est connecté -->
            <a href="espace_client.php" class="user-badge">
                <i class="fas fa-user-circle"></i>
                <span><?php echo htmlspecialchars($_SESSION['user_prenom'] ?? $_SESSION['user_nom'] ?? 'Mon Espace'); ?></span>
            </a>
            <a href="deconnexion.php" class="btn-logout" title="Déconnexion">
                <i class="fas fa-power-off"></i>
            </a>
        <?php else: ?>
            <!-- Liens pour utilisateur anonyme -->
            <a href="connexion.php">Connexion</a>
            <a href="inscription.php" class="btn-main">S'inscrire</a>
        <?php endif; ?>
    </nav>
</header>

<main>