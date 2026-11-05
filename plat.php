<?php
/**
 * FICHIER : plat.php
 * ROLE : Affichage de la fiche détaillée d'un plat avec image locale, description et allergènes.
 * DESIGN : Thème sombre, accents ocres, carte centrée et allergènes stylisés.
 */

// Inclusions sécurisées (compatible selon la structure des dossiers)
if (file_exists('includes/header.php')) {
    require_once 'includes/header.php';
} else {
    require_once 'header.php';
}

require_once 'db.php';

// Récupération et sécurisation de l'ID du plat depuis l'URL
$plat_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$plat = null;
$allergenes = [];

if ($pdo && $plat_id > 0) {
    try {
        // Récupération des données du plat avec sa description
        $stmt = $pdo->prepare("SELECT id, nom_plat, type_plat, description FROM plat WHERE id = ?");
        $stmt->execute([$plat_id]);
        $plat = $stmt->fetch(PDO::FETCH_ASSOC);

        // Récupération des allergènes liés via la table de liaison plat_allergene
        $stmt_allergene = $pdo->prepare("
            SELECT a.libelle 
            FROM allergene a
            JOIN plat_allergene pa ON a.id = pa.id_allergene
            WHERE pa.id_plat = ?
        ");
        $stmt_allergene->execute([$plat_id]);
        $allergenes = $stmt_allergene->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        $plat = null;
    }
}

// Si le plat n'existe pas ou ID invalide
if (!$plat) {
    echo "
    <main style='padding: 100px 8%; text-align: center; min-height: 60vh;'>
        <h2 style='color: var(--ocre); font-family: \"Playfair Display\", serif; font-size: 2rem;'>Plat introuvable</h2>
        <p style='color: #888; margin-top: 15px;'>Le plat demandé n'est pas répertorié au menu.</p>
        <a href='menus.php' style='display: inline-block; margin-top: 25px; color: var(--white); background: var(--ocre); padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: bold;'>← Retour aux menus</a>
    </main>";
    
    if (file_exists('includes/footer.php')) {
        require_once 'includes/footer.php';
    } else {
        require_once 'footer.php';
    }
    exit;
}

// Mappage complet des 21 visuels de plats locaux par ID
$images_plats = [
    1  => 'assets/img/noel_tradi/entree_nt.jpg',
    2  => 'assets/img/noel_tradi/plat_nt.jpg',
    3  => 'assets/img/noel_tradi/dessert_nt.jpg',
    4  => 'assets/img/noel_presti/entree_np.jpg',
    5  => 'assets/img/noel_presti/plat_np.jpg',
    6  => 'assets/img/noel_presti/dessert_np.jpg',
    7  => 'assets/img/paques_tradi/entree_pt.jpg',
    8  => 'assets/img/paques_tradi/plat_pt.jpg',
    9  => 'assets/img/paques_tradi/dessert_pt.jpg',
    10 => 'assets/img/paques_presti/entree_pp.jpg',
    11 => 'assets/img/paques_presti/plat_pp.jpg',
    12 => 'assets/img/paques_presti/dessert_pp.jpg',
    13 => 'assets/img/grill_terroir/entree_gt.jpg',
    14 => 'assets/img/grill_terroir/plat_gt.jpg',
    15 => 'assets/img/grill_terroir/dessert_gt.jpg',
    16 => 'assets/img/cocktail/entree_cd.jpg',
    17 => 'assets/img/cocktail/plat_cd.jpg',
    18 => 'assets/img/cocktail/dessert_cd.jpg',
    19 => 'assets/img/green/entree_gf.jpg',
    20 => 'assets/img/green/plat_gf.jpg',
    21 => 'assets/img/green/dessert_gf.jpg'
];

$image_plat = $images_plats[$plat['id']] ?? 'assets/img/others/chef_vg.jpg';
?>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(25px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .plat-card {
        max-width: 920px;
        margin: 0 auto;
        background: #111;
        border: 1px solid #222;
        border-radius: 16px;
        padding: 35px;
        display: flex;
        flex-wrap: wrap;
        gap: 35px;
        align-items: center;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.6);
        transition: border-color 0.3s ease;
    }

    .plat-card:hover {
        border-color: rgba(217, 119, 6, 0.4);
    }

    .allergen-badge {
        display: inline-block;
        background: rgba(239, 68, 68, 0.12);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.4);
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        margin: 4px 6px 4px 0;
    }

    .no-allergen {
        color: #4ade80;
        font-size: 0.9rem;
        font-style: italic;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .img-zoom {
        overflow: hidden;
        border-radius: 12px;
        border: 1px solid #222;
    }

    .img-zoom img {
        transition: transform 0.6s ease;
    }

    .img-zoom:hover img {
        transform: scale(1.06);
    }

    .btn-back {
        color: #888;
        text-decoration: none;
        font-size: 0.95rem;
        transition: color 0.3s ease;
        display: inline-block;
        margin-bottom: 25px;
    }

    .btn-back:hover {
        color: var(--ocre);
    }
</style>

<main style="padding: 60px 8%; min-height: 70vh;" class="fade-in">
    
    <div style="max-width: 920px; margin: 0 auto;">
        <a href="javascript:history.back()" class="btn-back">
            <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>Retour au menu
        </a>
    </div>

    <div class="plat-card">
        <!-- Visuel du plat -->
        <div style="flex: 1; min-width: 280px;">
            <div class="img-zoom" style="height: 320px; background: #0a0a0a;">
                <img src="<?php echo htmlspecialchars($image_plat); ?>" 
                     alt="<?php echo htmlspecialchars($plat['nom_plat']); ?>" 
                     style="width: 100%; height: 100%; object-fit: cover; display: block;"
                     onerror="this.onerror=null; this.src='assets/img/others/chef_vg.jpg';">
            </div>
        </div>

        <!-- Détails du plat -->
        <div style="flex: 1.2; min-width: 280px;">
            <span style="color: var(--ocre); text-transform: uppercase; font-size: 0.82rem; font-weight: bold; letter-spacing: 1.5px; display: block; margin-bottom: 8px;">
                <?php echo htmlspecialchars($plat['type_plat']); ?>
            </span>

            <h1 style="color: var(--white); font-family: 'Playfair Display', serif; font-size: 2.2rem; margin: 0 0 15px;">
                <?php echo htmlspecialchars($plat['nom_plat']); ?>
            </h1>

            <p style="color: #aaa; line-height: 1.7; margin-bottom: 25px; font-size: 0.98rem;">
                <?php echo htmlspecialchars($plat['description'] ?? 'Plat gastronomique préparé à partir de produits frais et locaux par nos chefs.'); ?>
            </p>

            <!-- Section Allergènes -->
            <div style="padding-top: 20px; border-top: 1px solid #222;">
                <h3 style="color: var(--white); font-size: 1.05rem; margin: 0 0 12px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-exclamation-triangle" style="color: var(--ocre);"></i>
                    Allergènes répertoriés
                </h3>
                <div>
                    <?php if (!empty($allergenes)): ?>
                        <?php foreach ($allergenes as $allergene): ?>
                            <span class="allergen-badge">
                                <i class="fas fa-info-circle" style="font-size: 0.75rem; margin-right: 5px;"></i>
                                <?php echo htmlspecialchars($allergene); ?>
                            </span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="no-allergen">
                            <i class="fas fa-check-circle"></i>
                            Aucun allergène majeur répertorié pour cette préparation.
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php 
if (file_exists('includes/footer.php')) {
    require_once 'includes/footer.php';
} else {
    require_once 'footer.php';
}
?>