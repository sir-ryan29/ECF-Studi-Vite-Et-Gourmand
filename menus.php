<?php 
// --- FICHIER : menus.php ---
// --- ROLE : Affiche dynamiquement les menus depuis la base de données ---
include 'header.php'; 
require_once 'db.php';
?>

<div style="padding: 50px 8%;">
    <h1>Notre Carte</h1>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-top: 40px;">
        <?php
        // Récupération des données dans la base
        $stmt = $pdo->query("SELECT * FROM menu");
        
        // Boucle d'affichage sécurisée
        while ($menu = $stmt->fetch()) {
            echo '
            <div style="background: white; border-radius: 20px; padding: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <h3>' . htmlspecialchars($menu['titre']) . '</h3>
                <p>' . htmlspecialchars($menu['description']) . '</p>
                <p><strong>' . htmlspecialchars($menu['prix_par_personne_min']) . '€ / pers.</strong></p>
                <a href="commande.php?id=' . $menu['id'] . '" class="btn-orange">Commander</a>
            </div>';
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>