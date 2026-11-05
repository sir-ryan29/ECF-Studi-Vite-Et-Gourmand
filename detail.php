<?php
/**
 * FICHIER : detail.php
 * ROLE : Fiche technique dynamique d'un menu et détail de sa composition.
 */

// Connexion BDD et en-tête de page
require_once 'includes/db.php';
require_once 'includes/header.php';

// Récupération et sécurisation de l'ID passé dans l'URL
$menu_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$menu = null;
$plats_menu = [];

// Vérification de la connexion PDO et requête pour le menu et ses plats
if ($pdo && $menu_id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT id, titre, description, prix_par_personne_min, stock_disponible FROM menu WHERE id = ?");
        $stmt->execute([$menu_id]);
        $menu = $stmt->fetch(PDO::FETCH_ASSOC);

        // Récupération des plats associés via la table de liaison menu_plat
        $stmt_plats = $pdo->prepare("
            SELECT p.id, p.nom_plat, p.type_plat 
            FROM plat p 
            JOIN menu_plat mp ON p.id = mp.id_plat 
            WHERE mp.id_menu = ?
        ");
        $stmt_plats->execute([$menu_id]);
        $plats_associes = $stmt_plats->fetchAll(PDO::FETCH_ASSOC);

        foreach ($plats_associes as $p) {
            $plats_menu[$p['type_plat']] = $p;
        }
    } catch (PDOException $e) {
        $menu = null;
    }
}

// Affichage d'un message propre si le menu n'est pas trouvé
if (!$menu) {
    echo "
    <main style='padding: 100px; text-align: center; min-height: 60vh;'>
        <h2 style='color: var(--ocre); font-family: \"Playfair Display\", serif;'>Menu introuvable</h2>
        <p style='color: #888; margin-top: 15px;'>Le menu que vous recherchez n'existe pas ou a été retiré de la carte.</p>
        <a href='menus.php' style='display: inline-block; margin-top: 20px; color: var(--white); background: var(--ocre); padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold;'>← Retour aux menus</a>
    </main>";
    require_once 'includes/footer.php';
    exit;
}

// Mappage des dossiers d'images locales par ID de menu
$mapping_menus = [
    1 => ['dossier' => 'noel_tradi',   'code' => 'nt'],
    2 => ['dossier' => 'noel_presti',  'code' => 'np'],
    3 => ['dossier' => 'paques_tradi', 'code' => 'pt'],
    4 => ['dossier' => 'paques_presti','code' => 'pp'],
    5 => ['dossier' => 'grill_terroir','code' => 'gt'],
    6 => ['dossier' => 'cocktail',     'code' => 'cd'],
    7 => ['dossier' => 'green',        'code' => 'gf']
];

// Configuration des chemins d'accès aux visuels
if (isset($mapping_menus[$menu['id']])) {
    $dossier = $mapping_menus[$menu['id']]['dossier'];
    $code    = $mapping_menus[$menu['id']]['code'];

    $img_entree  = "assets/img/{$dossier}/entree_{$code}.jpg";
    $img_plat    = "assets/img/{$dossier}/plat_{$code}.jpg";
    $img_dessert = "assets/img/{$dossier}/dessert_{$code}.jpg";
} else {
    $img_entree  = 'assets/img/others/chef_vg.jpg';
    $img_plat    = 'assets/img/others/chef_vg.jpg';
    $img_dessert = 'assets/img/others/chef_vg.jpg';
}

// Liens vers les fiches de plats
$id_entree  = $plats_menu['entree']['id'] ?? (($menu['id'] - 1) * 3 + 1);
$id_plat    = $plats_menu['plat']['id'] ?? (($menu['id'] - 1) * 3 + 2);
$id_dessert = $plats_menu['dessert']['id'] ?? (($menu['id'] - 1) * 3 + 3);

$link_entree  = "plat.php?id=" . $id_entree;
$link_plat    = "plat.php?id=" . $id_plat;
$link_dessert = "plat.php?id=" . $id_dessert;
?>

<!-- Styles CSS spécifiques à la fiche détail -->
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
        border-radius: 15px;
    }
    .img-zoom img {
        transition: transform 0.6s ease;
    }
    .img-zoom:hover img {
        transform: scale(1.08);
    }
    .composition-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-top: 25px;
    }
    .plat-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }
    @media (max-width: 768px) {
        .composition-grid {
            grid-template-columns: 1fr;
        }
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<main style="padding: 60px 8%; min-height: 70vh;" class="fade-in">
    <div style="margin-bottom: 40px;">
        <a href="menus.php" style="color: #888; text-decoration: none; transition: color 0.3s;">← Retour aux menus</a>
    </div>

    <div style="display: flex; flex-wrap: wrap; gap: 50px; align-items: flex-start;">
        <!-- Visuel principal du menu -->
        <div style="flex: 1; min-width: 300px; max-width: 550px;">
            <div class="dynamic-card img-zoom" style="height: 400px; background: #111;">
                <img src="<?php echo $img_plat; ?>" alt="<?php echo htmlspecialchars($menu['titre']); ?>" style="width: 100%; height: 100%; object-fit: cover; display: block;">
            </div>
        </div>

        <!-- Informations détaillées du menu -->
        <div style="flex: 1.2; min-width: 320px; color: var(--white);">
            <h1 style="color: var(--ocre); font-size: 2.5rem; font-family: 'Playfair Display', serif; margin: 0;">
                <?php echo htmlspecialchars($menu['titre']); ?>
            </h1>
            <p style="color: #aaa; font-style: italic; margin-bottom: 30px;">"Une célébration des saveurs généreuses."</p>
            
            <div class="dynamic-card" style="margin-bottom: 35px; background: #0a0a0a; padding: 25px; border-radius: 12px;">
                <p style="color: #888; line-height: 1.7; margin: 0;">
                    <?php echo htmlspecialchars($menu['description']); ?>
                </p>
                <p style="color: #666; font-size: 0.85rem; margin-top: 15px;">
                    Stock disponible : <strong><?php echo htmlspecialchars($menu['stock_disponible']); ?></strong> portions
                </p>
            </div>

            <!-- Composition du menu (Entrée, Plat, Dessert) -->
            <div style="margin-bottom: 35px;">
                <h3 style="color: var(--white); font-size: 1.3rem; margin-bottom: 15px; font-family: 'Playfair Display', serif;">Composition du menu (Cliquer pour voir la fiche & allergènes)</h3>
                <div class="composition-grid">
                    <!-- Entrée -->
                    <a href="<?php echo $link_entree; ?>" class="plat-link">
                        <div class="dynamic-card" style="background: #111; border-radius: 10px; overflow: hidden; cursor: pointer;">
                            <div class="img-zoom" style="height: 120px;">
                                <img src="<?php echo $img_entree; ?>" alt="Entrée" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div style="padding: 10px; text-align: center;">
                                <span style="color: var(--ocre); font-size: 0.8rem; font-weight: bold; text-transform: uppercase;">Entrée</span>
                                <span style="display: block; color: #aaa; font-size: 0.75rem; margin-top: 4px;">Voir allergènes →</span>
                            </div>
                        </div>
                    </a>

                    <!-- Plat Principal -->
                    <a href="<?php echo $link_plat; ?>" class="plat-link">
                        <div class="dynamic-card" style="background: #111; border-radius: 10px; overflow: hidden; cursor: pointer;">
                            <div class="img-zoom" style="height: 120px;">
                                <img src="<?php echo $img_plat; ?>" alt="Plat Principal" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div style="padding: 10px; text-align: center;">
                                <span style="color: var(--ocre); font-size: 0.8rem; font-weight: bold; text-transform: uppercase;">Plat Principal</span>
                                <span style="display: block; color: #aaa; font-size: 0.75rem; margin-top: 4px;">Voir allergènes →</span>
                            </div>
                        </div>
                    </a>

                    <!-- Dessert -->
                    <a href="<?php echo $link_dessert; ?>" class="plat-link">
                        <div class="dynamic-card" style="background: #111; border-radius: 10px; overflow: hidden; cursor: pointer;">
                            <div class="img-zoom" style="height: 120px;">
                                <img src="<?php echo $img_dessert; ?>" alt="Dessert" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div style="padding: 10px; text-align: center;">
                                <span style="color: var(--ocre); font-size: 0.8rem; font-weight: bold; text-transform: uppercase;">Dessert</span>
                                <span style="display: block; color: #aaa; font-size: 0.75rem; margin-top: 4px;">Voir allergènes →</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Tarif et bouton de réservation -->
            <div style="display: flex; align-items: center; gap: 30px; border-top: 1px solid #1a1a1a; padding-top: 30px; margin-bottom: 40px;">
                <div>
                    <span style="font-size: 2rem; font-weight: bold; color: var(--ocre);">
                        <?php echo htmlspecialchars($menu['prix_par_personne_min']); ?> €
                    </span>
                    <span style="font-size: 0.9rem; color: #666; display: block;">/ pers. min.</span>
                </div>
                <div>
                    <a href="commande.php?id=<?php echo $menu['id']; ?>" class="dynamic-card" style="background: var(--ocre); color: var(--white); text-decoration: none; padding: 15px 35px; border-radius: 8px; font-weight: bold; display: inline-block;">
                        Réserver ce menu
                    </a>
                </div>
            </div>

            <!-- Avis clients -->
            <section style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #333;">
                <h3 style="color: var(--white); font-size: 1.5rem; margin-bottom: 20px;">Ce qu'ils en pensent</h3>
                
                <div class="dynamic-card" style="background: #1a1a1a; padding: 20px; border-radius: 15px; margin-bottom: 15px;">
                    <div style="color: var(--ocre); font-size: 0.8rem; margin-bottom: 5px;">
                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                    </div>
                    <p style="color: #ccc; font-style: italic; margin: 0;">"Une explosion de saveurs, le rapport qualité-prix est imbattable sur ce menu !"</p>
                    <span style="display: block; margin-top: 10px; color: #777; font-size: 0.8rem;">— Sophie M.</span>
                </div>

                <div class="dynamic-card" style="background: #1a1a1a; padding: 20px; border-radius: 15px;">
                    <div style="color: var(--ocre); font-size: 0.8rem; margin-bottom: 5px;">
                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="far fa-star"></i>
                    </div>
                    <p style="color: #ccc; font-style: italic; margin: 0;">"Le dressage est digne d'un grand restaurant. Parfait pour une soirée entre amis."</p>
                    <span style="display: block; margin-top: 10px; color: #777; font-size: 0.8rem;">— Thomas B.</span>
                </div>
            </section>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>