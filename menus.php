<?php
/**
 * FICHIER : menus.php
 * ROLE : Affichage dynamique de la carte des menus depuis la base de données.
 */

// Connexion BDD et en-tête de page
require_once 'includes/db.php';
require_once 'includes/header.php';
?>

<!-- Styles CSS spécifiques à la grille des menus et effets d'apparition -->
<style>
    .fade-in {
        animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .dynamic-card {
        transition: all 0.4s ease-in-out;
        border: 1px solid #222;
    }
    .dynamic-card:hover {
        transform: translateY(-6px) scale(1.01);
        border-color: var(--ocre);
        box-shadow: 0 12px 30px rgba(212, 160, 23, 0.25);
    }
    .img-zoom {
        overflow: hidden;
        border-radius: 12px 12px 0 0;
        height: 220px;
        background: #111;
    }
    .img-zoom a {
        display: block;
        width: 100%;
        height: 100%;
    }
    .img-zoom img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.6s ease;
    }
    .img-zoom:hover img {
        transform: scale(1.08);
    }
    .title-link {
        color: var(--white);
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .title-link:hover {
        color: var(--ocre);
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<main style="padding: 80px 8%;" class="fade-in">
    <!-- En-tête de section -->
    <div style="text-align: center; margin-bottom: 50px;">
        <h1 style="font-family: 'Playfair Display', serif; color: var(--white); font-size: 2.5rem; margin: 0;">Notre Carte</h1>
        <p style="color: #888; margin-top: 10px;">Découvrez nos menus d'exception élaborés par Julie et José.</p>
    </div>

    <!-- Grille des cartes menus -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto;">
        <?php
        // Contrôle de la disponibilité de l'instance PDO
        if (!$pdo) {
            echo "<p style='text-align: center; color: #ff5555; grid-column: 1 / -1;'>Erreur : Connexion à la base de données indisponible.</p>";
        } else {
            try {
                // Requête SQL pour sélectionner tous les menus
                $stmt = $pdo->query("SELECT id, titre, description, prix_par_personne_min FROM menu");
                $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Association des images selon l'identifiant du menu
                $images_menus = [
                    1 => 'assets/img/noel_tradi/plat_nt.jpg',     // Noël Traditionnel
                    2 => 'assets/img/noel_presti/plat_np.jpg',    // Noël Prestige
                    3 => 'assets/img/paques_tradi/plat_pt.jpg',   // Pâques Traditionnel
                    4 => 'assets/img/paques_presti/plat_pp.jpg',  // Pâques Prestige
                    5 => 'assets/img/grill_terroir/plat_gt.jpg',  // Grill / Terroir
                    6 => 'assets/img/cocktail/plat_cd.jpg',       // Cocktail Dînatoire
                    7 => 'assets/img/green/plat_gf.jpg'           // Green & Fraîcheur
                ];

                if ($menus) {
                    // Boucle d'affichage pour chaque menu
                    foreach ($menus as $menu) {
                        $titre = htmlspecialchars($menu['titre']);
                        $desc  = htmlspecialchars($menu['description']);
                        $prix  = htmlspecialchars($menu['prix_par_personne_min']);
                        $id    = intval($menu['id']);

                        // Image associée ou visuel par défaut
                        $image_url = $images_menus[$id] ?? 'assets/img/others/chef_vg.jpg';

                        echo "
                        <div class='dynamic-card' style='background: #111; border-radius: 15px; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between;'>
                            <!-- Visuel cliquable du menu -->
                            <div class='img-zoom'>
                                <a href='detail.php?id={$id}' title='Consulter le menu {$titre}'>
                                    <img src='{$image_url}' alt='{$titre}'>
                                </a>
                            </div>
                            
                            <!-- Contenu et détails -->
                            <div style='padding: 25px; display: flex; flex-direction: column; flex-grow: 1; justify-content: space-between;'>
                                <div>
                                    <h3 style='margin-top: 0; font-family: \"Playfair Display\", serif; font-size: 1.5rem;'>
                                        <a href='detail.php?id={$id}' class='title-link'>{$titre}</a>
                                    </h3>
                                    <p style='color: #888; font-size: 0.95rem; line-height: 1.5; margin: 15px 0;'>{$desc}</p>
                                </div>
                                <div>
                                    <p style='font-weight: bold; font-size: 1.3rem; color: var(--ocre); margin: 20px 0 15px;'>
                                        {$prix} € <span style='font-size: 0.9rem; color: #666; font-weight: normal;'>/ pers. min.</span>
                                    </p>
                                    <a href='detail.php?id={$id}' class='dynamic-card' style='text-decoration: none; display: block; text-align: center; background: var(--ocre); color: var(--white); padding: 12px; border-radius: 8px; font-weight: bold;'>
                                        Voir le détail
                                    </a>
                                </div>
                            </div>
                        </div>";
                    }
                } else {
                    echo "<p style='text-align: center; color: #888; grid-column: 1 / -1;'>Aucun menu actuellement disponible.</p>";
                }
            } catch (PDOException $e) {
                echo "<p style='text-align: center; color: #ff5555; grid-column: 1 / -1;'>Erreur lors de la récupération des menus.</p>";
            }
        }
        ?>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>