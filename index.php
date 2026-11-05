<?php
/**
 * FICHIER : index.php
 * ROLE : Page d'accueil officielle de Vite & Gourmand.
 * DESIGN : Thème sombre, accents ocres et présentation des menus vedettes.
 */

// Connexion BDD et en-tête de page
require_once 'includes/db.php';
require_once 'includes/header.php';

// Récupération des 3 premiers menus mis en avant
$featured_menus = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("
            SELECT m.*, t.libelle AS theme_nom, r.libelle AS regime_nom 
            FROM menu m 
            LEFT JOIN theme t ON m.id_theme = t.id 
            LEFT JOIN regime r ON m.id_regime = r.id 
            ORDER BY m.id ASC LIMIT 3
        ");
        $featured_menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $featured_menus = [];
    }
}

// Association des visuels principaux par identifiant de menu
$menu_images = [
    1 => 'assets/img/noel_tradi/plat_nt.jpg',
    2 => 'assets/img/noel_presti/plat_np.jpg',
    3 => 'assets/img/paques_tradi/plat_pt.jpg',
    4 => 'assets/img/paques_presti/plat_pp.jpg',
    5 => 'assets/img/grill_terroir/plat_gt.jpg',
    6 => 'assets/img/cocktail/plat_cd.jpg',
    7 => 'assets/img/green/plat_gf.jpg',
];
?>

<!-- Styles CSS spécifiques à la page d'accueil -->
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

    @keyframes pulseGlow {
        0% { box-shadow: 0 0 0 0 rgba(217, 119, 6, 0.4); }
        70% { box-shadow: 0 0 0 12px rgba(217, 119, 6, 0); }
        100% { box-shadow: 0 0 0 0 rgba(217, 119, 6, 0); }
    }

    .animated-section {
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .hero-section {
        background: linear-gradient(180deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.95) 100%), url('assets/img/others/chef_vg.jpg') center/cover no-repeat;
        padding: 90px 20px 70px;
        text-align: center;
        border-bottom: 1px solid #222;
    }

    .btn-primary {
        background: var(--ocre);
        color: var(--white);
        padding: 14px 32px;
        border-radius: 8px;
        font-weight: bold;
        text-decoration: none;
        font-size: 1rem;
        display: inline-block;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 4px 15px rgba(217, 119, 6, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-3px) scale(1.03);
        box-shadow: 0 8px 25px rgba(217, 119, 6, 0.5);
        background: #e68208;
    }

    .btn-secondary {
        background: transparent;
        color: var(--white);
        border: 1px solid #444;
        padding: 14px 32px;
        border-radius: 8px;
        font-weight: bold;
        text-decoration: none;
        font-size: 1rem;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        border-color: var(--white);
        background: rgba(255, 255, 255, 0.05);
        transform: translateY(-3px);
    }

    .btn-outline {
        display: inline-block;
        border: 1px solid var(--ocre);
        color: var(--ocre);
        padding: 12px 28px;
        border-radius: 8px;
        font-weight: bold;
        text-decoration: none;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .btn-outline:hover {
        background: var(--ocre);
        color: var(--white);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(217, 119, 6, 0.3);
    }

    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        width: 100%;
        max-width: 1100px;
        margin-top: 25px;
    }

    .menu-card {
        background: #111;
        border: 1px solid #222;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
    }

    .menu-card:hover {
        transform: translateY(-8px);
        border-color: var(--ocre);
        box-shadow: 0 12px 30px rgba(217, 119, 6, 0.25);
    }

    .menu-card-img-link {
        display: block;
        width: 100%;
        height: 200px;
        overflow: hidden;
    }

    .menu-card-img-link img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .menu-card:hover .menu-card-img-link img {
        transform: scale(1.08);
    }

    .menu-card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        justify-content: space-between;
        text-align: left;
    }

    .badge-tag {
        display: inline-block;
        background: rgba(217, 119, 6, 0.15);
        color: var(--ocre);
        border: 1px solid var(--ocre);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .badge-tag.pulse {
        animation: pulseGlow 2.5s infinite;
    }

    .feature-box {
        background: #0d0d0d;
        border: 1px solid #222;
        padding: 25px 20px;
        border-radius: 12px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .feature-box:hover {
        transform: translateY(-5px);
        border-color: var(--ocre);
        background: #141414;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
    }

    .feature-box i {
        font-size: 2rem;
        color: var(--ocre);
        margin-bottom: 15px;
        transition: transform 0.3s ease;
    }

    .feature-box:hover i {
        transform: scale(1.15) rotate(5deg);
    }

    .link-arrow {
        color: var(--ocre);
        text-decoration: none;
        font-weight: bold;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: gap 0.3s ease;
    }

    .link-arrow:hover {
        gap: 10px;
    }

    .title-link {
        color: var(--white);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .title-link:hover {
        color: var(--ocre);
    }
</style>

<main>
    <!-- Section d'accroche principale (Hero) -->
    <section class="hero-section">
        <div class="animated-section" style="max-width: 800px; margin: 0 auto;">
            <span class="badge-tag pulse" style="margin-bottom: 15px;">Artisans Traiteurs à Bordeaux</span>
            <h1 style="font-family: 'Playfair Display', serif; color: var(--white); font-size: 3.2rem; margin: 15px 0 20px; line-height: 1.2;">
                L'Excellence Gastronomique pour Vos Événements
            </h1>
            <p style="color: #bbb; font-size: 1.15rem; line-height: 1.7; margin-bottom: 35px;">
                Depuis 25 ans, Julie et José mettent leur passion culinaire à votre service pour créer des moments d'exception. Menus de saison, produits régionaux et recettes faites maison.
            </p>
            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <a href="menus.php" class="btn-primary">
                    Découvrir nos menus
                </a>
                <a href="contact.php" class="btn-secondary">
                    Nous contacter
                </a>
            </div>
        </div>
    </section>

    <!-- Conteneur principal des sections de la page d'accueil -->
    <div style="padding: 60px 8%; display: flex; flex-direction: column; align-items: center; gap: 60px;">

        <!-- Présentation des points forts -->
        <section class="animated-section" style="width: 100%; max-width: 1100px; display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px;">
            <div class="feature-box">
                <i class="fas fa-leaf"></i>
                <h3 style="color: var(--white); font-size: 1.1rem; margin-bottom: 8px;">Éco-responsable</h3>
                <p style="color: #777; font-size: 0.9rem; margin: 0;">Produits frais, de saison et d'origine locale.</p>
            </div>
            <div class="feature-box">
                <i class="fas fa-utensils"></i>
                <h3 style="color: var(--white); font-size: 1.1rem; margin-bottom: 8px;">Fait Maison</h3>
                <p style="color: #777; font-size: 0.9rem; margin: 0;">25 ans de passion et de savoir-faire artisanal.</p>
            </div>
            <div class="feature-box">
                <i class="fas fa-truck"></i>
                <h3 style="color: var(--white); font-size: 1.1rem; margin-bottom: 8px;">Livraison Dédiée</h3>
                <p style="color: #777; font-size: 0.9rem; margin: 0;">Respect strict de la chaîne du froid sur Bordeaux.</p>
            </div>
            <div class="feature-box">
                <i class="fas fa-star"></i>
                <h3 style="color: var(--white); font-size: 1.1rem; margin-bottom: 8px;">Sur-Mesure</h3>
                <p style="color: #777; font-size: 0.9rem; margin: 0;">Adaptation à vos régimes et événements.</p>
            </div>
        </section>

        <!-- Affichage des menus vedettes -->
        <?php if (!empty($featured_menus)): ?>
        <section class="animated-section" style="width: 100%; max-width: 1100px; text-align: center;">
            <span style="color: var(--ocre); text-transform: uppercase; font-size: 0.85rem; font-weight: bold; letter-spacing: 1px;">Nos Incontournables</span>
            <h2 style="font-family: 'Playfair Display', serif; color: var(--white); font-size: 2.2rem; margin: 10px 0 30px;">
                Sélection de la Carte
            </h2>

            <div class="card-grid">
                <?php foreach ($featured_menus as $menu): ?>
                    <?php $img = $menu_images[$menu['id']] ?? 'assets/img/others/chef_vg.jpg'; ?>
                    <div class="menu-card">
                        <!-- Visuel cliquable vers le détail du menu -->
                        <a href="detail.php?id=<?php echo $menu['id']; ?>" class="menu-card-img-link" title="Voir le détail du <?php echo htmlspecialchars($menu['titre']); ?>">
                            <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($menu['titre']); ?>">
                        </a>
                        
                        <div class="menu-card-body">
                            <div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <span class="badge-tag"><?php echo htmlspecialchars($menu['theme_nom'] ?? 'Menu'); ?></span>
                                    <span style="color: var(--ocre); font-weight: bold; font-size: 1.1rem;">
                                        <?php echo number_format($menu['prix_par_personne_min'], 2, ',', ' '); ?> € <span style="font-size: 0.75rem; color: #888;">/pers</span>
                                    </span>
                                </div>
                                <h3 style="color: var(--white); font-family: 'Playfair Display', serif; font-size: 1.3rem; margin: 10px 0 8px;">
                                    <a href="detail.php?id=<?php echo $menu['id']; ?>" class="title-link">
                                        <?php echo htmlspecialchars($menu['titre']); ?>
                                    </a>
                                </h3>
                                <p style="color: #888; font-size: 0.9rem; line-height: 1.5; margin-bottom: 15px;">
                                    <?php echo htmlspecialchars($menu['description']); ?>
                                </p>
                            </div>
                            <div style="border-top: 1px solid #222; padding-top: 15px; display: flex; justify-content: space-between; align-items: center;">
                                <span style="color: #666; font-size: 0.85rem;">
                                    <i class="fas fa-user-friends" style="margin-right: 5px;"></i>Min. <?php echo $menu['nb_personne_min']; ?> pers.
                                </span>
                                <a href="detail.php?id=<?php echo $menu['id']; ?>" class="link-arrow">
                                    Voir le menu <span>→</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div style="margin-top: 40px;">
                <a href="menus.php" class="btn-outline">
                    Voir l'ensemble de nos 7 menus
                </a>
            </div>
        </section>
        <?php endif; ?>

        <!-- Presentation de l'équipe et savoir-faire -->
        <section class="animated-section" style="background: #111; width: 100%; max-width: 1100px; padding: 40px; border-radius: 15px; border: 1px solid #222; display: flex; flex-wrap: wrap; gap: 30px; align-items: center;">
            <div style="flex: 1; min-width: 280px; text-align: left;">
                <span style="color: var(--ocre); text-transform: uppercase; font-size: 0.85rem; font-weight: bold; letter-spacing: 1px;">Savoir-Faire & Passion</span>
                <h2 style="font-family: 'Playfair Display', serif; color: var(--white); font-size: 2rem; margin: 10px 0 15px;">
                    Julie & José : Artisans Traiteurs
                </h2>
                <p style="color: #999; line-height: 1.7; margin-bottom: 15px;">
                    Chaque événement a son histoire. Depuis 25 ans à Bordeaux, nous composons nos cartes à partir d'ingrédients soigneusement sélectionnés auprès de producteurs locaux éco-responsables.
                </p>
                <p style="color: #999; line-height: 1.7; margin: 0;">
                    De l'élaboration des recettes jusqu'à la livraison sur votre lieu de réception, nous garantissons fraîcheur, ponctualité et haut niveau de finition.
                </p>
            </div>
            <div style="flex: 1; min-width: 280px; height: 260px; border-radius: 12px; overflow: hidden; border: 1px solid #222;">
                <img src="assets/img/others/chef_vg.jpg" alt="Julie et José" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            </div>
        </section>

    </div>
</main>

<?php require_once 'includes/footer.php'; ?>