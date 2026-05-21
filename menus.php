<?php
// --- FICHIER : menus.php ---
// --- ROLE : Affichage dynamique de la carte des menus ---

include 'header.php'; 
require_once 'db.php'; 
?>

<div style="padding: 50px 8%;">
    <h1 style="text-align: center; margin-bottom: 40px; font-family: 'Arvo', serif;">Notre Carte</h1>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
        <?php
        if (!$pdo) {
            echo "<p style='text-align: center; color: red;'>Erreur : Connexion à la base de données indisponible.</p>";
        } else {
            $stmt = $pdo->query("SELECT id, titre, description, prix_par_personne_min FROM menu");
            $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($menus) {
                foreach ($menus as $menu) {
                    echo <<<HTML
                    <div style="background: #ffffff; border-radius: 20px; padding: 25px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border: 1px solid #eee;">
                        <h3 style="margin-top: 0; font-family: 'Arvo', serif;">{$menu['titre']}</h3>
                        <p style="color: #666; font-size: 0.95em;">{$menu['description']}</p>
                        <p style="font-weight: bold; font-size: 1.2em; color: #2d5a27;">
                            {$menu['prix_par_personne_min']} € / pers.
                        </p>
                        <a href="commande.php?id={$menu['id']}" class="btn-success" style="text-decoration: none; display: inline-block;">
                            Commander
                        </a>
                    </div>
HTML;
                }
            } else {
                echo "<p style='text-align: center;'>Aucun menu actuellement disponible.</p>";
            }
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>